<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DefaultSetting;
use App\Models\Mail_setting;
use App\Models\Seo_setting;
use App\Models\Social_login_setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    // Update Env Function
    public function updateEnv($envKey, $envValue)
    {
        $envFilePath = app()->environmentFilePath();
        $strEnv = file_get_contents($envFilePath);
        $strEnv.="\n";
        $keyStartPosition = strpos($strEnv, "{$envKey}=");
        $keyEndPosition = strpos($strEnv, "\n",$keyStartPosition);
        $oldLine = substr($strEnv, $keyStartPosition, $keyEndPosition-$keyStartPosition);

        if(!$keyStartPosition || !$keyEndPosition || !$oldLine){
            $strEnv.="{$envKey}={$envValue}\n";
        }else{
            $strEnv=str_replace($oldLine, "{$envKey}={$envValue}",$strEnv);
        }
        $strEnv=substr($strEnv, 0, -1);
        file_put_contents($envFilePath, $strEnv);
    }

    public function defaultSetting(){
        $default_setting = DefaultSetting::first();
        return view('admin.setting.default', compact('default_setting'));
    }

    public function defaultSettingUpdate(Request $request, $id){
        $request->validate([
            'app_name_en' => 'required',
            'app_name_bn' => 'required',
            'app_url' => 'required',
            'time_zone' => 'required',
            'logo_photo' => 'nullable|image|mimes:png,jpg,jpeg',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);
        $this->updateEnv("APP_NAME", "'$request->app_name_en'");
        $this->updateEnv("APP_URL", "'$request->app_url'");
        $this->updateEnv("TIME_ZONE", "'$request->time_zone'");

        $default_setting = DefaultSetting::where('id', $id)->first();

        $default_setting_data = [
            'app_url' => $request->app_url,
            'time_zone' => $request->time_zone,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
            'instagram_link' => $request->instagram_link,
            'linkedin_link' => $request->linkedin_link,
            'youtube_link' => $request->youtube_link,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
            'en' => [
                'app_name' => $request->app_name_en,
                'support_phone' => $request->support_phone_en,
                'support_email' => $request->support_email_en,
                'address' => $request->address_en,
            ],
            'bn' => [
                'app_name' => $request->app_name_bn,
                'support_phone' => $request->support_phone_bn,
                'support_email' => $request->support_email_bn,
                'address' => $request->address_bn,
            ],
        ];

        $default_setting->update($default_setting_data);

        // Logo Photo Upload
        if($request->hasFile('logo_photo')){
            if($default_setting->logo_photo != NULL){
                unlink(base_path("public/uploads/default_photo/").$default_setting->logo_photo);
            }
            $logo_photo_name = "Logo-Photo".".". $request->file('logo_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/default_photo/").$logo_photo_name;
            Image::make($request->file('logo_photo'))->resize(192, 40)->save($upload_link);
            DefaultSetting::where('id', $id)->update([
                'logo_photo' => $logo_photo_name
            ]);
        }

        // Favicon Upload
        if($request->hasFile('favicon')){
            if($default_setting->favicon != NULL){
                unlink(base_path("public/uploads/default_photo/").$default_setting->favicon);
            }
            $favicon_name = "Favicon".".". $request->file('favicon')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/default_photo/").$favicon_name;
            Image::make($request->file('favicon'))->resize(70, 70)->save($upload_link);
            DefaultSetting::where('id', $id)->update([
                'favicon' => $favicon_name
            ]);
        }

        $notification = array(
            'message' => 'Default setting details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function mailSetting(){
        $mail_setting = Mail_setting::first();
        return view('admin.setting.mail', compact('mail_setting'));
    }

    public function mailSettingUpdate(Request $request, $id){
        $request->validate([
            'mailer' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'from_address' => 'required',
        ]);
        $this->updateEnv("MAIL_MAILER", $request->mailer);
        $this->updateEnv("MAIL_HOST", $request->host);
        $this->updateEnv("MAIL_PORT", $request->port);
        $this->updateEnv("MAIL_USERNAME", $request->username);
        $this->updateEnv("MAIL_PASSWORD", $request->password);
        $this->updateEnv("MAIL_ENCRYPTION", $request->encryption);
        $this->updateEnv("MAIL_FROM_ADDRESS", $request->from_address);
        Mail_setting::where('id', $id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Mail details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function seoSetting(){
        $seo_setting = Seo_setting::first();
        return view('admin.setting.seo', compact('seo_setting'));
    }

    public function seoSettingUpdate(Request $request, $id){
        $request->validate([
            'seo_image' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        $seo_setting = Seo_setting::where('id', $id)->first();

        Seo_setting::where('id', $id)->update([
            'title' => $request->title,
            'keywords' => $request->keywords,
            'author' => $request->author,
            'description' => $request->description,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        // SEO Photo Upload
        if($request->hasFile('seo_image')){
            if($seo_setting->seo_image != NULL){
                unlink(base_path("public/uploads/default_photo/").$seo_setting->seo_image);
            }
            $seo_image_name = "Seo-Image".".". $request->file('seo_image')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/default_photo/").$seo_image_name;
            Image::make($request->file('seo_image'))->resize(800, 800)->save($upload_link);
            Seo_setting::where('id', $id)->update([
                'seo_image' => $seo_image_name
            ]);
        }
        $notification = array(
            'message' => 'SEO setting details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function socialLoginSetting(){
        $social_login_setting = Social_login_setting::first();
        return view('admin.setting.social-login', compact('social_login_setting'));
    }

    public function socialLoginSettingUpdate(Request $request, $id){
        $request->validate([
            '*' => 'required',
            'google_auth_status' => 'nullable',
            'facebook_auth_status' => 'nullable',
        ]);

        $this->updateEnv("GOOGLE_CLIENT_ID", $request->google_client_id);
        $this->updateEnv("GOOGLE_CLIENT_SECRET", $request->google_client_secret);
        $this->updateEnv("FACEBOOK_CLIENT_ID", $request->facebook_client_id);
        $this->updateEnv("FACEBOOK_CLIENT_SECRET", $request->facebook_client_secret);

        if ($request->google_auth_status == NULL) {
            $google_auth_status = "No";
        } else {
            $google_auth_status = $request->google_auth_status;
        }

        if ($request->facebook_auth_status == NULL) {
            $facebook_auth_status = "No";
        } else {
            $facebook_auth_status = $request->facebook_auth_status;
        }

        Social_login_setting::where('id', $id)->update([
            'google_auth_status' => $google_auth_status,
            'google_client_id' => $request->google_client_id,
            'google_client_secret' => $request->google_client_secret,
            'facebook_auth_status' => $facebook_auth_status,
            'facebook_client_id' => $request->facebook_client_id,
            'facebook_client_secret' => $request->facebook_client_secret,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Social login details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
