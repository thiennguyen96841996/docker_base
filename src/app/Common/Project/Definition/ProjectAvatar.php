<?php

namespace App\Common\Project\Definition;

/**
 * イメージに関連した定義を持つクラス。
 * @package \App\Common\Project\Definition
 */
class ProjectAvatar
{
    const PROJECT_AVATAR_FOLDER = 'Project/';
    const PROJECT_AVATAR_FOLDER_TMP = 'Project/Tmp/';
    const PROJECT_IMAGE_FOLDER = 'Image';
    const PROJECT_WEBP_FOLDER = 'Webp';

    // Webp resize
    const PROJECT_WEBP_IMAGE_RESIZE_WIDTH = 200;
    const PROJECT_WEBP_IMAGE_RESIZE_HEIGHT = 250;

    const CLIENT_PROJECT_DEFAULT_AVATAR = 'img/cat.jpeg';
}
