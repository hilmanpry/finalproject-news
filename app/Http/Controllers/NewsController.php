<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class PatienstController extends Controller
{
    # Method index - Get All Resources
    public function index()
    {
        // menggunakan model news untuk select data
        $news = News::all();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($news->isNotEmpty()) {
            $user = [
                'message' => 'Get All news',
                'data' => $news
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($news->isEmpty()) {
            $data = [
                'message' => 'Data is Empty',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 504
            return response()->json($data, 500);
        }
    }

    # Method store - Add Resource 
    public function store(Request $request){
        // Kenapa field out_date_at tidak di di wajibkan(required)? karena field tersebut di isi tergantung kondisi, 
        // jika pasien tersebut baru masuk maka tanggal keluarnya tidak bisa di tentukan
        // (karena penyakit tidak tau kapan bisa sembuhnya)

        // menangkap data request
        $input = $request->validate([
            'name' => 'required',
            'phone' => 'numeric|required',
            'address' => 'string|required',
            'status' => 'string|required',
            'in_date_at' => 'date|required',
            'out_date_at' => 'date'
        ]);
        
        if ($input) {
            // membuat atau memasukkan data kedalam database
            $news = News::create($input);

            $data = [
                'message' => 'Resource is added succesfuly',
                'data' => $news
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 201);
        
        // Terjadi kegagalan saat menambahkan data pasient
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method show - Get Detail Resource
    public function show($id)
    {
        // cari id news yang ingin didapatkan
        $news = News::find($id);

        // perbadingan untuk data yg ada dan tidak ada
        if ($news) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $news,
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method Update - Edit Resource
    public function update(Request $request, $id){
        // Mengambil id news yang ingin di dapatkan
        $news = news::find($id);
        
        if($news) {

            // menangkap data request
            $input = [
                'name' => $request->name ?? $news->name,
                'phone' => $request->phone ?? $news->phone,
                'address' => $request->address ?? $news->address,
                'status' => $request->status ?? $news->status,
                'in_date_at' => $request->in_date_at ?? $news->in_date_at,
                'out_date_at' => $request->out_date_at ?? $news->out_date_at
            ];

            // melakukan update data
            $news->update($input);

            $data = [
                'message' => 'Resource is update succesfuly',
                'data' => $news
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }

        
    }
    # Method Delete - Delete Resource
    public function destroy($id)
    {
        $news = news::find($id);

        if ($news) {
            $news->delete();

            $data = [
                'message' => 'Resource is deleted succesfuly'
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method search - Search Resource by name
    public function search($name)
    {
        // Mencari dan menyesuaikan data di dalama database dengan yang di cari
        $names = News::where('name', 'like', "%".$name."%")->get();

        // perbadingan untuk data yg ada dan tidak ada
        if ($names) {
            $data = [
                'message' => 'Get detail News',
                'data' => $names,
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'News not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method positive - Get Positive Resource
    public function positive()
    {
        // menggunakan method count untuk mengetahui banyak record yg terkena status positif
        $total = News::where('status', 'Positif')->count();

        // mencari status positif menggunakan where and get
        $news = News::where('status', 'Positif')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($news->isNotEmpty()) {
            $user = [
                'message' => 'Get Positive Resource',
                'total' => $total,
                'data' => $news
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($news->isEmpty()) {
            $data = [
                'message' => 'Positive is Empty',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 504
            return response()->json($data, 500);
        }
    }

    # Method recovered - Get Recovered Resource
    public function recovered()
    {
        // menggunakan method count untuk mengetahui banyak record yg terkena status sembuh
        $total = News::where('status', 'Sembuh')->count();

        // mencari status sembuh menggunakan where and get
        $news = News::where('status', 'Sembuh')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($news->isNotEmpty()) {
            $user = [
                'message' => 'Get recovered resource',
                'total' => $total,
                'data' => $news
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($news->isEmpty()) {
            $data = [
                'message' => 'Recovered is Empty',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 504
            return response()->json($data, 500);
        }
    }

    # Method dead - Get Recovered Resource
    public function dead()
    {
        // menggunakan method count untuk mengetahui banyak record yg terkena status dead
        $total = News::where('status', 'Dead')->count();

        // mencari status dead menggunakan where and get
        $news = News::where('status', 'Dead')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($news->isNotEmpty()) {
            $user = [
                'message' => 'Get dead resource',
                'total' => $total,
                'data' => $news
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($news->isEmpty()) {
            $data = [
                'message' => 'Dead is Empty',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 504
            return response()->json($data, 500);
        }
    }
}