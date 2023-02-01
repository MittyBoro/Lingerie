<?php

namespace App\Services\Cart\Storage;

use App\Services\Cart\Models\CartStorage;
use Darryldecode\Cart\CartCollection;

class DBStorage {

    private $storage = [];


    public function has($key)
    {
        return (bool) $this->find($key);
    }

    private function find($key)
    {
        if (!isset($this->storage[$key])) {
            $this->storage[$key] = CartStorage::find($key);
        }

        return $this->storage[$key];
    }

    public function get($key)
    {
        $row = $this->find($key);

        if ($row) {
            return new CartCollection($row->cart_data);
        }
        else {
            return [];
        }
    }

    public function put($key, $value)
    {
        if (strlen($key) >= 255)
            throw new \Exception('Invalid key: ' . $key);

        $row = $this->find($key);

        if($row) {
            $row->cart_data = $value;
            $row->save();
        }
        else {
            $row = CartStorage::create([
                'id' => $key,
                'cart_data' => $value
            ]);
        }

        $this->storage[$key] = $row;
    }
}
