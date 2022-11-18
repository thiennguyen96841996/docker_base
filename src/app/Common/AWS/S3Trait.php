<?php

namespace App\Common\AWS;

use App\Common\Post\Definition\PostAvatar;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * イメージに関連した定義を持つトライ。
 * @package \App\Common\AWS
 */
trait S3Trait
{
    /**
     * @param string $folder
     * @param string $file
     * @return string
     */
    public static function display(string $folder, string $file): string
    {
        return env('POST_IMAGE_LINK') . self::getEnvString() . '/' . $folder . $file;
    }

    /**
     * @param string $folder
     * @param string $file
     * @return string
     */
    public static function displayWebp(string $folder, string $file): string
    {
        return env('POST_IMAGE_LINK') . self::getEnvString() . '/' . $folder . $file . '.webp';
    }

    /**
     * @param string $folder
     * @param string $file
     * @param string $name
     * @return bool|string
     */
    public static function putFileAs(string $folder, string $file, string $name): bool|string
    {
        return Storage::disk('s3')->putFileAs(self::getEnvString() . '/' . $folder, $file, $name, 'private');
    }

    /**
     * @param string $folder
     * @param string $file
     * @return bool|string
     */
    public static function putFile(string $folder, string $file): bool|string
    {
        return Storage::disk('s3')->put(self::getEnvString() . '/' . $folder, $file, 'private');
    }

    /**
     * @param string $from
     * @param string $to
     * @return bool
     */
    public static function moveFile(string $from, string $to): bool
    {
        return Storage::disk('s3')->move(self::getEnvString() . '/' . $from, self::getEnvString() . '/' . $to);
    }

    /**
     * @param string $folder
     * @return bool
     */
    public static function deleteDirectory(string $folder): bool
    {
        return Storage::disk('s3')->deleteDirectory(self::getEnvString() . '/' . $folder);
    }

    /**
     * @param string $file
     * @return bool
     */
    public static function deleteFile(string $file): bool
    {
        return Storage::disk('s3')->delete(self::getEnvString() . '/' . $file);
    }

    /**
     * @param string $file
     * @return \Intervention\Image\Image
     */
    public static function convertToWebp(string $file): \Intervention\Image\Image
    {
        return Image::make($file)->encode('webp')->resize(PostAvatar::POST_WEBP_IMAGE_RESIZE_WIDTH, PostAvatar::POST_WEBP_IMAGE_RESIZE_HEIGHT);
    }

    /**
     * 環境の文字列取得
     *
     * @return string S3の画像のpathで利用する環境の文字列取得
     */
    public static function getEnvString(): string
    {
        if(is_local()) {
            return 'dev';
        } elseif(is_staging()) {
            return 'stg';
        } elseif(is_production()) {
            return 'prod';
        } else {
            return '';
        }
    }
}
