<?php

// Project Zulfikar Hilman 2022
// CovidApp

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    # Method index - Get All Resources
    public function index()
    {
        // menggunakan model news untuk select data
        $news = News::all();


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

            // mengembalikan data (json) dan kode 200 (the request succeeded)
            return response()->json($data, 200);

        // terjadi kesalahan karena server error, anonym
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 404 4
            return response()->json($data, 404);
        }
    }

    # Method store - Add Resource 
    public function store(Request $request){

        // menangkap data request
        $input = $request->validate([
            'title' => 'required',
            'author' => 'string|required',
            'description' => 'string|required',
            'content' => 'text|required',
            'url' => 'string|required',
            'url_image' => 'string|required',
            'out_date_at' => 'date',
            'category' => 'required'
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
        
        // Terjadi kegagalan saat menambahkan data news
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
    public function update(Request $request, News $news, $id){
        // Mengambil id news yang ingin di dapatkan
        $news = news::find($id);
        
        if($news) {

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

    # Method search - Search Resource by title
    public function search($title)
    {
        // Mencari dan menyesuaikan data di dalama database dengan yang di cari
        $news = News::where('title', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->orWhere('content', 'like', "%$keyword%")
            ->orWhere('category', 'like', "%$keyword%")
            ->get();

        // perbadingan untuk data yg ada dan tidak ada
        if ($news) {
            $data = [
                'message' => 'Get detail News',
                'data' => $news,
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

    # Get Sport Resource
    public function sport()
    {
        // mencari data menggunakan where and get
        $news = News::where('category', 'sport')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($news->isNotEmpty()) {
            $user = [
                'message' => 'Get Sport Resource',
                'data' => $news
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($news->isEmpty()) {
            $data = [
                'message' => 'Sport not Found',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Get Finance Resource
    public function finance()
    {
        // mencari data finance menggunakan where and get
        $news = News::where('category', 'finance')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($news->isNotEmpty()) {
            $user = [
                'message' => 'Get Finance resource',
                'data' => $news
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur status code
            return response()->json($user, 200);
            
        // menggunakan elif jika data kosong
        } elseif ($news->isEmpty()) {
            $data = [
                'message' => 'Finance Not Found',
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    #Get Automotive Resource
    public function automotive()
    {
        // mencari category dead menggunakan where and get
        $news = News::where('category', 'automotive')->get();

        // menggunakan collection method
        // menggunakan if jika datanya tidak kosong
        if ($news->isNotEmpty()) {
            $user = [
                'message' => 'Get Automotive resource',
                'data' => $news
            ];
    
            //menggunakan response json laravel otomatis set header content type ke json
            //otomatis mengubah data array ke JSON mengatur category code
            return response()->json($user, 200);

        // terjadi kesalahan karena server error / yang tidak dikenal
        } else {
            $data = [
                'message' => 'An error occurred',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }
}
