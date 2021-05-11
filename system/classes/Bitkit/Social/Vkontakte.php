<?
namespace Bitkit\Social;
class Vkontakte
{

    public function __construct($vk_token , $api_version, $link)
    {
        $this->token =  $vk_token;
        $this->version = $api_version;
        $this->domain =  'https://api.vk.com/method';
        $this->link =  $link;
    }

    public function getPostAuthor()
    {
        $info_str = explode('wall', $this->link);
        $info = explode('_', $info_str[1]);
        $vk_user_id = (int)$info[0];
        return $vk_user_id;
    }

    public function getPostId()
    {
        $info_str = explode('wall', $this->link);
        $info = explode('_', $info_str[1]);
        $vk_post_id = (int)$info[1];
        return $vk_post_id;
    }

    /**
     * Getting link as Post
     */

    public function getPost()
    {
        $vk_user_id = $this->getPostAuthor();
        $vk_post_id = $this->getPostId();
        return json_decode(file_get_contents($this->domain."/wall.getById?posts=".$vk_user_id."_".$vk_post_id."&v=$this->version&access_token=".$this->token), true);
    }

    public function getPostAuthorId()
    {
        return $this->getPost()['response'][0]['text'];
    }

    public function getPostText()
    {
        return $this->getPost()['response'][0]['text'];
    }

    public function getPostDate()
    {
        return $this->getPost()['response'][0]['date'];
    }

    public function getPostAttachments()
    {
        return $this->getPost()['response'][0]['attachments'];
    }

    public function getPostPhotos()
    {
        $photo_arr = array();
        foreach ($this->getPostAttachments() as $photo){
            array_push($photo_arr, $photo['photo']['photo_1280']);
        }
        return $photo_arr;
    }


    /**
     * Getting link as Profile
     */

    public function getProfileIdFromLink()
    {
        $info_str = explode('/', $this->link);
        $vk_user_id = str_replace('id','', $info_str[3]);
        return $vk_user_id;
    }

    public function getProfile()
    {
        $vk_user_id = $this->getProfileIdFromLink();
        return json_decode(file_get_contents($this->domain."/users.get?user_id=".$vk_user_id."&v=$this->version&fields=photo_max_orig,about&access_token=".$this->token), true);
    }

    public function getProfileCustomFields($fields_str)
    {
        $vk_user_id = $this->getProfileIdFromLink();
        $fields_str ? $fields = "fields=$fields_str" : $fields = "";
        return json_decode(file_get_contents($this->domain."/users.get?user_id=".$vk_user_id."&v=$this->version&$fields&access_token=".$this->token), true);
    }

    public function getProfileCustomField($field)
    {
        $vk_user_id = $this->getProfileIdFromLink();
        $field ? $fields = "fields=$field" : $fields = "";
        return json_decode(file_get_contents($this->domain."/users.get?user_id=".$vk_user_id."&v=$this->version&$fields&access_token=".$this->token), true)[0][$field];
    }

    public function getProfileId()
    {
        return $this->getProfile()['response'][0]['id'];
    }

    public function getProfileFirstName($link)
    {
        return $this->getProfile()['response'][0]['first_name'];
    }

    public function getProfileLastName()
    {
        return $this->getProfile()['response'][0]['last_name'];
    }

    public function getProfilePhoto()
    {
        return $this->getProfile()['response'][0]['photo_max_orig'];
    }

    public function getProfilePosts(int $num)
    {
        return $this->getPost()['response'][0]['date'];
    }

}
