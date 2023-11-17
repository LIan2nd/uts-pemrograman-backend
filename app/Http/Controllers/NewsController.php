<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    /**
     *  Menampilkan semua data News
     */
    public function index()
    {

        // Mendapatkan semua data News
        $news = News::all();

        // Cek apakah News memiliki data atau tidak
        if ($news->isEmpty()) {
            $data = [
                "message" => "Data is empty",
            ];
        } else {
            $data = [
                "message" => "Get All News",
                "data" => $news
            ];
        }

        // Mengembalikan Response berbentuk json
        return response()->json($data, 200);

    }

    /**
     * Menambahkan data News baru
     */
    public function store(Request $request)
    {

        // Membuat Validasi Data
        $validatedData = $request->validate([
            "title" => "required|min:1|max:255",
            "description" => "required|max:255",
            "content" => "required|min:10",
            "url" => "required",
            "url_image" => "required",
            "category" => "required|min:3|max:255"
        ]);

        $validatedData['author'] = Auth::user()->name;

        // Membuat data dari data yang telah divalidasi
        $newsData = News::create($validatedData);

        // Mengirim data setelah success
        $data = [
            'message' => 'News is added successfully',
            'data' => $newsData
        ];

        // Mengembalikan response berbentuk json
        return response()->json($data, 201);
    }

    /**
     * Menampilkan data berita spesifik melalui id
     */
    public function show($id)
    {
        // Mencari data berita melalui id
        $newsData = News::find($id);

        // Cek apakah data ada atau tidak
        if (!$newsData) {
            $data = [
                'message' => 'News not found'
            ];
            // Mengembalikan response berbentuk json jika data tidak ada
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Get Detail News',
            'data' => $newsData
        ];
        return response()->json($data, 200);
    }

    /**
     * memperbarui data berita spesifik melalui id
     */
    public function update(Request $request, $id)
    {

        // Mencari data melalui Id
        $newsData = News::find($id);

        // Cek apakah data ada atau tidak
        if (!$newsData) {
            $data = [
                'message' => 'News not found'
            ];
            // Mengembalikan response berbentuk json jika data tidak ada
            return response()->json($data, 404);
        }

        // Membuat Validasi Data untuk update sekaligus untuk mengirim partial data
        $dataInput = [
            "title" => $request->title ?? $newsData->title,
            "author" => $request->author ?? $newsData->author,
            "description" => $request->description ?? $newsData->description,
            "content" => $request->content ?? $newsData->content,
            "url" => $request->url ?? $newsData->url,
            "url_image" => $request->url_image ?? $newsData->url_image,
            "published_at" => $request->published_at ?? $newsData->published_at,
            "category" => $request->category ?? $newsData->category
        ];

        // Membuat data dari data yang telah divalidasi
        $newsData->update($dataInput);

        // Mengirim data setelah success
        $data = [
            'message' => 'News is update successfully',
            'data' => $newsData
        ];

        // Mengembalikan response berbentuk json
        return response()->json($data, 200);
    }

    /**
     * Menghapus data berita spesifik melalui id
     */
    public function destroy($id)
    {

        // Mencari data berita melalui id
        $newsData = News::find($id);

        // Cek apakah data ada atau tidak
        if (!$newsData) {
            $data = [
                'message' => 'News not found'
            ];
            // Mengembalikan response apabila data tidak ada
            return response()->json($data, 404);
        }

        // Menghapus data berita tersebut
        $newsData->delete();
        $data = [
            'message' => 'News is delete Successfully'
        ];

        return response()->json($data, 200);
    }

    /**
     * Method Search (Mencari pencarian berdasarkan title)
     */
    public function search(Request $request, $title)
    {
        // Mencari data dari title
        $newsData = News::where('title', 'like', '%' . $title . '%')->get();

        // Cek apakah data yang dicari dari title ada atau tidak
        if ($newsData->isEmpty()) {
            $data = [
                'message' => 'News not found'
            ];

            // Mengembalikan response Not Found
            return response()->json($data, 404);
        }

        // Data & Message dari data yang telah dicari melalui titile
        $data = [
            'message' => 'Get Searched News',
            'data' => $newsData
        ];
        // Pengembalian response
        return response()->json($data, 200);
    }


    /**
     * Method Pencarian Category Sport
     */
    public function sport()
    {

        // Mencari data berita berkategori sport
        $newsData = News::where('category', 'sport')->get();

        // Pengecekan apakah data yang berkategori sport ada atau tidak
        if ($newsData->isEmpty()) {
            $data = [
                'message' => 'News not found'
            ];

            // Pengembalian response not found
            return response()->json($data, 404);
        }

        // Jika ada, data dari category sport
        $data = [
            'message' => 'Get Sport News',
            'total' => $newsData->count(),
            'data' => $newsData
        ];

        // Pengembalian response pencarian category sport (Berhasil)
        return response()->json($data, 200);
    }

    /**
     * Method Pencarian Category Sport
     */
    public function finance()
    {
        // Pencarian data berita berkategori finance
        $newsData = News::where('category', 'finance')->get();
        if ($newsData->isEmpty()) {
            $data = [
                'message' => 'News not found'
            ];

            // Pengembalian response not found
            return response()->json($data, 404);
        }

        // Jika ada, data dari category finance
        $data = [
            'message' => 'Get Finance News',
            'total' => $newsData->count(),
            'data' => $newsData
        ];

        return response()->json($data, 200);
    }

    /**
     * Method Pencarian Category Sport
     */
    public function automotive()
    {

        // Mencari data berita yang berkategori automotive
        $newsData = News::where('category', 'automotive')->get();

        // Cek apakah data berita berkategori automotive ada atau tidak
        if ($newsData->isEmpty()) {
            $data = [
                'message' => 'News not found'
            ];

            // Pengembalian response not found
            return response()->json($data, 404);
        }

        // Jika ada, data dari category automotive
        $data = [
            'message' => 'Get Automotive News',
            'total' => $newsData->count(),
            'data' => $newsData
        ];

        // Pengembalian response json dari data pencarian automotive
        return response()->json($data, 200);
    }
}