<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 14.04.2015
 * Time: 9:06
 */

namespace rere\admin\widgets;


class TinyMce extends \dosamigos\tinymce\TinyMce
{
    public $language = 'ru';
    public $clientOptions = [
        'plugins' => [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern autoresize responsivefilemanager"
        ],

        'toolbar1' => "responsivefilemanager undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor | fullscreen",
        'external_filemanager_path' => '/app/rere/filemanager/vendor/filemanager/',
        'filemanager_title' => "Управление файлами",
        'external_plugins' => [
            'filemanager' => '/app/rere/filemanager/vendor/tinymce/plugins/responsivefilemanager/plugin.min.js',
            'responsivefilemanager' => '/app/rere/filemanager/vendor/tinymce/plugins/responsivefilemanager/plugin.min.js',
        ]
    ];
}