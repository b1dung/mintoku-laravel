#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$ROOT_DIR"

APP_NAME="mintoku_public_crm_db"
TIMESTAMP="$(date +%Y%m%d_%H%M%S)"
DEPLOY_DIR="${DEPLOY_DIR:-$ROOT_DIR/../deploy_artifacts}"
ZIP_PATH="$DEPLOY_DIR/${APP_NAME}_${TIMESTAMP}.zip"

mkdir -p "$DEPLOY_DIR"

run_artisan() {
    if command -v docker >/dev/null 2>&1 \
        && [ -f "$ROOT_DIR/../crm_camcom/docker-compose.yml" ] \
        && docker compose -f "$ROOT_DIR/../crm_camcom/docker-compose.yml" ps --services --filter status=running 2>/dev/null | grep -qx "mintoku_app"; then
        docker compose -f "$ROOT_DIR/../crm_camcom/docker-compose.yml" exec -T mintoku_app php artisan "$@"
    else
        php artisan "$@"
    fi
}

echo "==> Preparing Laravel writable directories"
mkdir -p \
    bootstrap/cache \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

chmod -R u+rwX bootstrap/cache storage 2>/dev/null || true

echo "==> Running Laravel cache commands"
run_artisan optimize:clear
run_artisan config:cache
run_artisan route:cache
run_artisan view:cache

echo "==> Creating deploy zip: $ZIP_PATH"
rm -f "$ZIP_PATH"

if command -v zip >/dev/null 2>&1; then
    zip -qr "$ZIP_PATH" . \
        -x '.git/*' \
        -x '.env' \
        -x 'node_modules/*' \
        -x 'storage/logs/*' \
        -x 'storage/framework/cache/*' \
        -x 'storage/framework/cache/data/*' \
        -x 'storage/framework/sessions/*' \
        -x 'storage/framework/views/*' \
        -x 'storage/app/livewire-tmp/*' \
        -x 'bootstrap/cache/*.php' \
        -x 'mintoku_laravel.sql' \
        -x 'public/storage'
else
    python3 - "$ZIP_PATH" <<'PY'
from pathlib import Path
from zipfile import ZipFile, ZIP_DEFLATED, ZipInfo
import os
import sys

root = Path.cwd()
zip_path = Path(sys.argv[1])

exclude_exact = {
    ".env",
    "mintoku_laravel.sql",
    "public/storage",
}
exclude_prefixes = (
    ".git/",
    "node_modules/",
    "storage/logs/",
    "storage/framework/cache/",
    "storage/framework/sessions/",
    "storage/framework/views/",
    "storage/app/livewire-tmp/",
    "bootstrap/cache/",
)

def skip(rel: str) -> bool:
    return rel in exclude_exact or any(rel.startswith(prefix) for prefix in exclude_prefixes)

with ZipFile(zip_path, "w", ZIP_DEFLATED) as zf:
    for path in sorted(root.rglob("*")):
        rel = path.relative_to(root).as_posix()
        if skip(rel) or path.is_dir():
            continue

        if path.is_symlink():
            info = ZipInfo(rel)
            info.create_system = 3
            info.external_attr = 0o120777 << 16
            zf.writestr(info, os.readlink(path))
        else:
            zf.write(path, rel)
PY
fi

echo "==> Done"
echo "$ZIP_PATH"
