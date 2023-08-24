<?php
class Request
{
    private array $data; //все данные переданные пользователем

    public function __construct()
    {
        $this->data = $this->xss($_REQUEST);
    }
    public function __get(string $name): mixed //доступ к переданным пользователем параметрам
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return false;
    }
    public function __isset(string $name): bool //проверка есть ли такой переданный параметр
    {
        return isset($this->data[$name]);
    }

    private function xss(array|string $data): array|string
    {
        if (is_array($data)) {
            $escaped = [];
            foreach ($data as $key => $value) {
                $escaped[$key] = $this->xss($value);
            }
            return $escaped;
        }
        return trim(htmlspecialchars($data));
    }
}
