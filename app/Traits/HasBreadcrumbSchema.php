<?php

namespace App\Traits;

trait HasBreadcrumbSchema
{
    /**
     * Tự động tạo mảng Breadcrumb Schema
     * $segments: Mảng các trang trung gian [ 'Tên' => 'Link' ]
     */
    public function getBreadcrumbSchema(array $segments = []): array
    {
        $itemListElement = [
            [
                "@type" => "ListItem",
                "position" => 1,
                "name" => "Trang chủ",
                "item" => url('/')
            ]
        ];

        $position = 2;
        foreach ($segments as $name => $url) {
            $itemListElement[] = [
                "@type" => "ListItem",
                "position" => $position++,
                "name" => $name,
                "item" => $url
            ];
        }

        // Thêm trang hiện tại vào cuối cùng
        $itemListElement[] = [
            "@type" => "ListItem",
            "position" => $position,
            "name" => $this->title ?? $this->name, // Tự động lấy title hoặc name
            "item" => url()->current()
        ];

        return [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => $itemListElement
        ];
    }
}