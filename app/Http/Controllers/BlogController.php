<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Faker\Provider\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class BlogController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        // $title=$request['title'];
        // $description=$request['description'];

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
        $imgName = $request->file('image')->getClientOriginalName();
        $imgPath = $request->file('image')->storeAs('public/images', $imgName);
        }

        // // $imgName = $request->file('image')->hashName();  // Generate a unique, random name...
        // // $imgPath = $request->file('image')->store('public/images');  //Generate and store a unique, random name

        Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imgName,
            'slug' => $slug,
        ]);

        // $blog=new Blog;
        // $blog->title=$request->input('title');
        // $blog->description=$request->input('description');
        // $blog->image =$imgName ;
        // $blog->slug=$slug;
        // $blog->save() ;

        // return redirect()->route('show.blog')->withSuccess('Blog created Successfully!!');
        return response()->json(['message' => 'Blog created Successfully!!']);
    }

    public function show()
    {
        return view('admin.blogs.view_blog_data');
    }

    public function fetchdata(Request $request)
    {
        $search = $request->input('search', '');

        if ($search !== "" && !empty($search)) {
            $blog = Blog::where('title', 'LIKE', "%$search%")->orWhere('description', 'LIKE', "%$search%")->orWhere('image', 'LIKE', "%$search%")->orderBy('id', 'DESC')->paginate(10)->withQueryString();
        } else {
            $blog = Blog::orderBy('id', 'DESC')->paginate(10);
        }

        return response()->json(['status' => 200, 'data' => $blog]);
        //return view('admin.blogs.view_blog_data', compact('search', 'blog', 'noResults'));
    }

    public function edit(Blog $blog)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            if (!$blog) {
                return response()->json(['error' => 'Blog not found'], 404);
            }

            $blog->title = $request->input('title');
            $blog->description = $request->input('description');

            if ($request->hasFile('new_image')) {

                if ($blog->image) {
                    Storage::delete('public/images/' . $blog->image);
                }

                $newImgName = $request->file('new_image')->getClientOriginalName();
                $newImgPath = $request->file('new_image')->storeAs('public/images', $newImgName);
                $blog->image = $newImgName;
            }
            $blog->slug = Str::slug($blog->title);
            $blog->save();

            return response()->json(['message' => 'Blog updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occured while updating the blog'],500);
        }
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['error' => 'Blog not found'], 404);
        }
        $blog->delete();

        return response()->json(['message' => 'Blog Deleted successfully']);
    }

    public function export(){
        $blog=Blog::all();
        $csvFileName='blog.csv';

        $headers = array(
            'Content-type' => 'text/csv',
            'Content-disposition' => 'attachment; filename="'.$csvFileName.'"',
        );

        $callback = function() use($blog){
            $file= fopen('php://output','w');
            fputcsv($file,['Title','Description','Image','Slug']);

            foreach($blog as $item){
                fputcsv($file,[$item->title, $item->description, $item->image, $item->slug]);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}
