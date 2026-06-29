<?php

if (! function_exists('get_field')) {
    /**
     * Lấy giá trị từ cột JSON extra_attributes (tương tự get_field của WordPress)
     *
     * @param mixed $model Đối tượng Model (Job, Company, v.v.)
     * @param string $key Khóa cần lấy (hỗ trợ dấu chấm cho mảng lồng nhau)
     * @param mixed $default Giá trị mặc định nếu không tìm thấy
     * @return mixed
     */
    function get_field($model, string $key, $default = null)
    {
        // Kiểm tra nếu model null hoặc không có thuộc tính extra_attributes
        if (!$model || !isset($model->extra_attributes)) {
            return $default;
        }

        // Nếu extra_attributes là chuỗi JSON, ta cần decode nó (nếu Model chưa cast)
        $attributes = is_array($model->extra_attributes)
            ? $model->extra_attributes
            : json_decode($model->extra_attributes, true);

        // Sử dụng data_get của Laravel để lấy dữ liệu theo kiểu "dot.notation"
        return data_get($attributes, $key, $default);
    }
}
