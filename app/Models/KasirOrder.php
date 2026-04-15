namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    protected $table = 'kasir';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id_pelanggan', 'total_harga', 'details'];

    protected $casts = [
        'details' => 'array', // otomatis decode JSON menjadi array
    ];
}