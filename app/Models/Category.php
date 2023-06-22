<?php

namespace App\Models;

use App\Models\Shared\Helper;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory, Helper;

    protected $fillable = [
        'id', 'name', 'shop_id', 'created_at'
    ];

    public static function persist(self $category)
    {
        DB::table($category->table)->upsert(
            [
                'id' => $category->getId(),
                'shop_id' => $category->getShopId(),
                'name' => $category->getName(),
                'created_at' => $category->getCreatedAt()->getTimestamp()
            ], 'id'
        );
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $table = 'category';

    public $timestamps = false;

//    private int $id;
//    private int $shop_id;
//    private string $name;
//    private DateTime $created_at;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shop_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
