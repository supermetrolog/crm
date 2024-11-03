<?

class Theme extends Unit
{

    public function setTable()
    {
        return 'core_themes';
    }

    public function title()
    {
        return $this->getField('title');
    }

    public function photo()
    {
        return json_decode($this->getField('photo'))[0];
    }

    public function logo()
    {
        return $this->getField('logo');
    }

    public function siteTitle()
    {
        return $this->getField('site_name');
    }

    public function icon()
    {
        return $this->getField('icon');
    }

    public function css()
    {
        return $this->getField('css_name');
    }

    public function metaTitle()
    {
        if ($this->getField('content_title')) {
            return $this->getField('content_title');
        } else {
            return $this->getField('title');
        }
    }

    public function metaKeywords()
    {
        if ($this->getField('content_keywords')) {
            return $this->getField('content_keywords');
        } else {
            return $this->getField('title');
        }
    }

    public function metaDescription()
    {
        if ($this->getField('content_description')) {
            return $this->getField('content_description');
        } else {
            return $this->getField('title');
        }
    }

    public function metaIcon()
    {
        return $this->getField('logo');
    }

}


