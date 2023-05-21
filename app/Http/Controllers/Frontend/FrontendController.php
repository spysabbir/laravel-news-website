<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Comment;
use App\Models\Comment_reply;
use App\Models\Contact_message;
use App\Models\DefaultSetting;
use App\Models\District;
use App\Models\Division;
use App\Models\News;
use App\Models\NewsTranslation;
use App\Models\PageSetting;
use App\Models\Photo_gallery;
use App\Models\Video_gallery;
use App\Models\Seo_setting;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Models\TagTranslation;
use App\Models\Union;
use App\Models\Upazila;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class FrontendController extends Controller
{
    public function index()
    {
        $seo_setting = Seo_setting::first();
        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();
        $all_news = News::where('status', 'Active')->get();
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $photo_galleries = Photo_gallery::where('status', 'Active')->latest()->take(8)->get();
        $video_galleries = Video_gallery::where('status', 'Active')->latest()->take(8)->get();
        $countries_id = News::where('country_id', '!=', 0)->groupBy('country_id')->pluck('country_id');
        SEOMeta::setTitle($seo_setting->title);
        SEOMeta::setDescription($seo_setting->description);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setDescription($seo_setting->description);
        OpenGraph::setTitle($seo_setting->title);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'articles');

        TwitterCard::setTitle($seo_setting->title);
        TwitterCard::setSite('@'.$default_setting->twitter_link);

        JsonLd::setTitle($seo_setting->title);
        JsonLd::setDescription($seo_setting->description);
        JsonLd::addImage(url()->current().'/uploads/default_photo/'.$seo_setting->seo_image);

        return view('frontend.index', compact('default_setting', 'tags', 'all_news', 'tranding_news', 'advertisements', 'photo_galleries', 'video_galleries', 'countries_id'));
    }

    public function changeLanguage(Request $request)
    {
        App::setLocale($request->language);
        session()->put('locale', $request->language);

        return redirect()->back();
    }

    public function page($slug)
    {
        $page = PageSetting::where('page_slug', $slug)->first();
        $default_setting = DefaultSetting::first();
        return view('frontend.page', compact('page', 'default_setting'));
    }

    public function findNews(Request $request)
    {
        $find_news = "";
        $result_news = News::orderBy('id', 'desc')->where('news_headline', 'LIKE', '%'.$request->search.'%')->limit(8)->get();
        if ($result_news->count() > 0) {
            foreach ($result_news as $news){
                $find_news .= '
                <a href="'.route('news.details', $news->news_slug).'">
                    <li>
                        <img src="'.asset('uploads/news_thumbnail_photo')."/".$news->news_thumbnail_photo.'" alt="">
                        <p>'.$news->news_headline.'</p>
                    </li>
                </a>
                ';
            }
        } else {
            $find_news .= '
                <li>
                    <strong class="text-danger p-2">Result Not Found</strong>
                </li>
            ';
        }

        return response()->json($find_news);
    }

    public function searchNews(Request $request)
    {
        $search_data = $request->news_headline;

        $all_news = "";
        $result_news = News::orderBy('id', 'desc')->where('news_headline', 'LIKE', '%'.$search_data.'%');

        $all_news = $result_news->paginate(20);

        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.search-news', compact('search_data', 'default_setting', 'tags', 'all_news', 'tranding_news', 'advertisements', 'categories'));
    }

    public function todayNews()
    {
        $archive_date = date('Y-m-d');
        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();
        $all_news = News::where('status', 'Active')->where('news.created_at', 'LIKE', '%'.$archive_date.'%')->paginate(16);
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.archive-news', compact('default_setting', 'tags', 'all_news', 'tranding_news', 'advertisements', 'archive_date', 'categories'));
    }

    public function archiveNewsResult(Request $request)
    {
        $archive_date = $request->archive_date;

        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();
        $all_news = News::where('status', 'Active')->where('news.created_at', 'LIKE', '%'.$archive_date.'%')->paginate(16);
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.archive-news', compact('default_setting', 'tags', 'all_news', 'tranding_news', 'advertisements', 'archive_date', 'categories'));
    }

    public function allNews()
    {
        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();
        $all_news = News::where('status', 'Active')->paginate(13);
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.all-news', compact('default_setting', 'tags', 'all_news', 'tranding_news', 'advertisements', 'categories'));
    }

    public function allCategory()
    {
        $default_setting = DefaultSetting::first();
        $all_news = News::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        return view('frontend.all-category', compact('default_setting', 'all_news', 'advertisements', 'tranding_news', 'categories'));
    }

    public function allTag()
    {
        $default_setting = DefaultSetting::first();
        $all_news = News::where('status', 'Active')->get();
        $tags = Tag::where('status', 'Active')->get();
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.all-tag', compact('default_setting', 'all_news', 'advertisements', 'tranding_news', 'tags', 'categories'));
    }

    public function categoryWiseNews($slug)
    {
        $category = CategoryTranslation::where('category_slug', $slug)->first();
        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();
        $all_news = News::where('status', 'Active')->where('news_category_id', $category->category_id )->paginate(12);
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.category-wise-news', compact('category', 'default_setting', 'tags', 'all_news', 'tranding_news', 'advertisements', 'categories'));
    }

    public function reporterWiseNews($id)
    {
        $reporter = Admin::where('id', $id)->first();
        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();
        $all_news = News::where('status', 'Active')->where('created_by', $reporter->id)->paginate(12);
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.reporter-wise-news', compact('reporter', 'default_setting', 'tags', 'all_news', 'tranding_news', 'advertisements', 'categories'));
    }

    public function tagWiseNews($slug)
    {
        $tag = TagTranslation::where('tag_slug', $slug)->first();
        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();

        $news_id = DB::table('news_tag')->where('tag_id', $tag->tag_id)->groupBy('news_id')->select('news_id')->paginate(12);

        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.tag-wise-news', compact('tag', 'default_setting', 'tags', 'news_id', 'tranding_news', 'advertisements', 'categories'));
    }

    public function newsDetails($slug)
    {
        $news_id = NewsTranslation::where('news_slug', $slug)->first()->news_id;
        $news_details = News::where('id', $news_id)->first();
        News::where('id', $news_details->id)->increment('news_view');
        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();
        $all_news = News::where('status', 'Active')->get();
        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $related_news = News::where('news_category_id', $news_details->news_category_id)->where('id', '!=', $news_details->id)->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $comments = Comment::where('news_id', $news_details->id)->get();
        $categories = Category::where('status', 'Active')->get();

        SEOMeta::setTitle($news_details->news_title);
        SEOMeta::setDescription($news_details->news_details);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setDescription($news_details->news_details);
        OpenGraph::setTitle($news_details->news_title);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'News');

        TwitterCard::setTitle($news_details->news_title);
        TwitterCard::setSite('@'.$default_setting->twitter_link);

        JsonLd::setTitle($news_details->news_title);
        JsonLd::setDescription($news_details->news_details);
        JsonLd::addImage(env('APP_URL').'/uploads/news_cover_photo/'.$news_details->news_cover_photo);

        return view('frontend.news-details', compact('news_details', 'default_setting', 'tags', 'all_news', 'tranding_news', 'related_news', 'advertisements', 'comments', 'categories'));
    }

    public function commentStore(Request $request)
    {
        if(!Auth::check()){
            return response()->json([
                'status' => 400,
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                '*' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 401,
                    'error'=> $validator->errors()->toArray()
                ]);
            }else{
                Comment::insert([
                    'news_id' => $request->news_id,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json([
                    'status' => 200,
                ]);
            }
        }
    }

    public function commentReplyStore(Request $request)
    {
        if(!Auth::check()){
            return response()->json([
                'status' => 400,
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                '*' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 401,
                    'error'=> $validator->errors()->toArray()
                ]);
            }else{
                Comment_reply::insert([
                    'comment_id' => $request->comment_id,
                    'user_id' => Auth::user()->id,
                    'reply' => $request->reply,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json([
                    'status' => 200,
                ]);
            }
        }
    }

    public function allGalleryPhoto()
    {
        $default_setting = DefaultSetting::first();
        $photo_galleries = Photo_gallery::where('status', 'Active')->latest()->paginate(20);
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.all-photo', compact('default_setting', 'photo_galleries', 'categories'));
    }
    public function allGalleryVideo()
    {
        $default_setting = DefaultSetting::first();
        $video_galleries = Video_gallery::where('status', 'Active')->latest()->paginate(20);
        $categories = Category::where('status', 'Active')->get();
        return view('frontend.all-video', compact('default_setting', 'video_galleries', 'categories'));
    }

    public function aboutUs()
    {
        $default_setting = DefaultSetting::first();
        $about_us = AboutUs::first();
        return view('frontend.about', compact('default_setting', 'about_us'));
    }

    public function contactUs()
    {
        $default_setting = DefaultSetting::first();
        return view('frontend.contact', compact('default_setting'));
    }

    public function contactMessageStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            '*' => 'required',
            'email' => 'required|email'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            Contact_message::insert([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status'=>200
            ]);
        }
    }

    public function subscriberStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subscriber_email' => 'required|email|unique:subscribers'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            Subscriber::insert([
                'subscriber_email' => $request->subscriber_email,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status'=>200
            ]);
        }
    }

    public function getDivisions(Request $request){
        $send_data = "<option value='0'>--Select Division--</option>";
        $divisions_id = News::where('country_id', $request->country_id)->groupBy('division_id')->select('division_id')->get();
        foreach ($divisions_id as $division_id) {
            $division = Division::find($division_id->division_id);
            $send_data .= "<option value='$division->id' >$division->name</option>";
        }
        return response()->json($send_data);
    }

    public function getDistricts(Request $request){
        $send_data = "<option value='0'>--Select District--</option>";
        $districts_id = News::where('division_id', $request->division_id)->groupBy('district_id')->select('district_id')->get();
        foreach ($districts_id as $district_id) {
            $district = District::find($district_id->district_id);
            $send_data .= "<option value='$district->id' >$district->name</option>";
        }
        return response()->json($send_data);
    }

    public function getUpazilas(Request $request){
        $send_data = "<option value='0'>--Select Upazila--</option>";
        $upazilas_id = News::where('district_id', $request->district_id)->groupBy('upazila_id')->select('upazila_id')->get();
        foreach ($upazilas_id as $upazila_id) {
            $upazila = Upazila::find($upazila_id->upazila_id);
            $send_data .= "<option value='$upazila->id' >$upazila->name</option>";
        }
        return response()->json($send_data);
    }

    public function getUnions(Request $request){
        $send_data = "<option value='0'>--Select Union--</option>";
        $unions_id = News::where('upazila_id', $request->upazila_id)->groupBy('union_id')->select('union_id')->get();
        foreach ($unions_id as $union_id) {
            $union = Union::find($union_id->union_id);
            $send_data .= "<option value='$union->id' >$union->name</option>";
        }
        return response()->json($send_data);
    }

    public function locationWiseNews(Request $request){
        $default_setting = DefaultSetting::first();
        $tags = Tag::where('status', 'Active')->get();

        $all_news = "";
        $query = News::where('status', 'Active');

        if($request->country_id){
            $query->where('news.country_id', $request->country_id);
        }
        if($request->division_id){
            $query->where('news.division_id', $request->division_id);
        }
        if($request->district_id){
            $query->where('news.district_id', $request->district_id);
        }
        if($request->upazila_id){
            $query->where('news.upazila_id', $request->upazila_id);
        }
        if($request->union_id){
            $query->where('news.union_id', $request->union_id);
        }

        $all_news = $query->select('news.*')->paginate(16);

        $tranding_news = News::where('status', 'Active')->orderBy('news_view', 'desc')->get();
        $advertisements = Advertisement::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        $countries_id = News::where('country_id', '!=', 0)->get();
        return view('frontend.location-wise-news', compact('default_setting', 'tags', 'all_news', 'tranding_news', 'advertisements', 'categories', 'countries_id'));
    }
}
