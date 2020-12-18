<?php

namespace app\components;


class FieldTemplate
{
    private const ADDON_INPUT_FIRST_PART = '
    {label}<div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">
    ';
    private const ADDON_INPUT_SECOND_PART = '
        </span>
      </div>
      {input}
    </div>
    {error}
    ';
    public const FILE_INPUT_TEMPLATE = '
    {label}
    <div class="custom-file">
      {input}
      <label class="custom-file-label" for="customFile">Выберите файл</label>
    </div>
    {error}
  ';

    public static function getAddonTemplate($text)
    {
      return self::ADDON_INPUT_FIRST_PART.$text.self::ADDON_INPUT_SECOND_PART;
    }
}
