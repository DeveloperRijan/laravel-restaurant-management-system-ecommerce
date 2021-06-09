<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontendUI extends Model
{
    use HasFactory;
    protected $fillable = [
    	"app_logo",
    	"app_title",
    	"home_banner_title",
    	"home_banner_title_color",
    	"home_banner_description",
    	"home_banner_description_color",

    	"search_box_bg_color",
        "search_box_text",
    	"search_box_text_color",
    	"search_button_text",
    	"search_button_text_color",
    	"search_button_bg_color",

        "easy_2_step_left_title",
        "easy_2_step_left_title_color",
        "easy_2_step_left_description",
        "easy_2_step_left_description_color",
        "easy_2_step_right_title",
        "easy_2_step_right_title_color",
        "easy_2_step_right_description",
        "easy_2_step_right_description_color",
        "easy_2_step_small_text",

        "app_section_bg_color",
        "app_section_title",
        "app_section_title_color",
        "app_section_description",
        "app_section_description_color",
        "play_store_app_link",
        "apple_app_link",

    	"footer_bg_color",
    	"facebook_url",
    	"twitter_url",
    	"linkedIn_url",
    	"youtube_url",
    	"instagram_url",

    	"singin_image",
    	"signup_image",
    	"reservation_image",

        "contact_email",
        "contact_phone",
        "contact_address"
    ];
}
