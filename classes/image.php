<?php

class Image
{

	public function create_filename($random_length)
{
    $array = array(0,1,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $text = "";

    for($x = 0; $x < $random_length; $x++)
    {
        $random = rand(0, 61);
        $text .= $array[$random];
    }
    
    return $text;
}

	public function image_crop($file_original, $file_cropped, $max_width, $max_height)
	{
		if(file_exists($file_original))
		{

			$image_original = imagecreatefromjpeg($file_original);

			$width_original = imagesx($image_original);
			$height_original = imagesy($image_original);
			
			if($height_original > $width_original)								
			{
				//make width equals to the max-width;
				$ratio = $max_width / $width_original;

				$new_width = $max_width;
				$new_height = $height_original * $ratio;

			}else
			{

				//make width equals to the max-width;
				$ratio = $max_height / $height_original;

				$new_height = $max_height;
				$new_width = $width_original * $ratio;

			}
		}

		//adjust if the max height and wifth are different
		if($max_width != $max_height)
		{

			if($max_height > $max_width)
			{

				if($max_height > $new_height)
				{
					$adjustment = ($max_height / $new_height);
				}else
				{
					$adjustment = ($new_height / $max_height);
				}

				$new_width = $new_width * $adjustment;
				$new_height = $new_height * $adjustment;
			}else
			{

				if($max_width > $new_width)
				{
					$adjustment = ($max_width / $new_width);
				}else
				{
					$adjustment = ($new_width / $max_width);
				}

				$new_width = $new_width * $adjustment;
				$new_height = $new_height * $adjustment;
			}
		}

		$new_image = imagecreatetruecolor($new_width, $new_height);

		//function that crops an image
		imagecopyresampled($new_image, $image_original, 0, 0, 0, 0, $new_width, $new_height, $width_original, $height_original);

		imagedestroy($image_original);

		if($max_width != $max_height)
		{

			if($max_width > $max_height)
			{

				$difference = ($new_height - $max_height);
				if($difference < 0){
					$difference = $difference * -1;
				}
				$y = round($difference / 2);
				$x = 0;
			}else
			{
				$difference = ($new_width - $max_height);
				if($difference < 0){
					$difference = $difference * -1;
				}
				$x = round($difference / 2);
				$y = 0;
			}

		}else
		{
			if($new_height > $new_width)
			{

				$difference = ($new_height - $new_width);
				$y = round($difference / 2);
				$x = 0;
			}else
			{
				$difference = ($new_width - $new_height);
				$x = round($difference / 2);
				$y = 0;
			}
	    }
		$image_cropped_new = imagecreatetruecolor($max_width, $max_height);
		imagecopyresampled($image_cropped_new, $new_image, 0, 0, $x, $y, $max_width, $max_height, $max_width, $max_height);

		imagedestroy($new_image);

		imagejpeg($image_cropped_new, $file_cropped, 90);
		imagedestroy($image_cropped_new);
	}

	//resize the image
	public function image_resize($file_original, $file_resized, $max_width, $max_height)
	{
		if(file_exists($file_original))
		{

			$image_original = imagecreatefromjpeg($file_original);

			$width_original = imagesx($image_original);
			$height_original = imagesy($image_original);
			
			if($height_original > $width_original)								
			{
				//make width equals to the max-width;
				$ratio = $max_width / $width_original;

				$new_width = $max_width;
				$new_height = $height_original * $ratio;

			}else
			{

				//make width equals to the max-width;
				$ratio = $max_height / $height_original;

				$new_height = $max_height;
				$new_width = $width_original * $ratio;

			}
		}

		//adjust if the max height and wifth are different
		if($max_width != $max_height)
		{

			if($max_height > $max_width)
			{

				if($max_height > $new_height)
				{
					$adjustment = ($max_height / $new_height);
				}else
				{
					$adjustment = ($new_height / $max_height);
				}

				$new_width = $new_width * $adjustment;
				$new_height = $new_height * $adjustment;
			}else
			{

				if($max_width > $new_width)
				{
					$adjustment = ($max_width / $new_width);
				}else
				{
					$adjustment = ($new_width / $max_width);
				}

				$new_width = $new_width * $adjustment;
				$new_height = $new_height * $adjustment;
			}
		}

		$new_image = imagecreatetruecolor($new_width, $new_height);

		//function that crops an image
		imagecopyresampled($new_image, $image_original, 0, 0, 0, 0, $new_width, $new_height, $width_original, $height_original);

		imagedestroy($image_original);

		imagejpeg($new_image, $file_resized, 90);
		imagedestroy($new_image);
	}
	//create thumbnail for cover image
	public function thumbnail_cover($filename)
	{

		$image_thumbnail = $filename . "cover_thumb_nail.jpg";
		if(file_exists($image_thumbnail))
		{

			return $image_thumbnail;
		}

		$this->image_crop($filename, $image_thumbnail, 576, 360);

		if(file_exists($image_thumbnail))
		{
			return $image_thumbnail;
		}else
		{
			return $filename;
		}
	}

	//create thumbnail for profile image
	public function thumbnail_profile($filename)
	{

		$image_thumbnail = $filename . "profile_thumb_nail.jpg";
		if(file_exists($image_thumbnail))
		{

			return $image_thumbnail;
		}

		$this->image_crop($filename, $image_thumbnail, 600, 600);

		if(file_exists($image_thumbnail))
		{
			return $image_thumbnail;
		}else
		{
			return $filename;
		}
	}

	//create thumbnail for post image
	public function thumbnail_post($filename)
	{

		$image_thumbnail = $filename . "post_thumb_nail.jpg";
		if(file_exists($image_thumbnail))
		{

			return $image_thumbnail;
		}

		$this->image_crop($filename, $image_thumbnail, 600, 600);

		if(file_exists($image_thumbnail))
		{
			return $image_thumbnail;
		}else
		{
			return $filename;
		}
	}
}