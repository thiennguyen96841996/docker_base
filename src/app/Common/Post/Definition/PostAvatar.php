<?php

namespace App\Common\Post\Definition;

/**
 * イメージに関連した定義を持つクラス。
 * @package \App\Common\Post\Definition
 */
class PostAvatar
{
    const POST_AVATAR_FOLDER = 'Post/';
    const POST_AVATAR_FOLDER_TMP = 'Post/Tmp/';
    const POST_IMAGE_FOLDER = 'Image';
    const POST_WEBP_FOLDER = 'Webp';

    // Webp resize
    const POST_WEBP_IMAGE_RESIZE_WIDTH = 200;
    const POST_WEBP_IMAGE_RESIZE_HEIGHT = 250;

    const CLIENT_POST_DEFAULT_AVATAR = 'img/cat.jpeg';
}
