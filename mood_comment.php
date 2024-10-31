<?php
class mood_comment {


    private $_mood_comment_config = array();

    function __construct($_mood_comment_config) {
        $this->_mood_comment_config = $_mood_comment_config;
    }
    public function getMoodCommentHeader(){
        global $post;
        $id = intval($post->ID);
        echo "<link rel='stylesheet' href='".plugins_url('my-mood-comment/css/style.css')."' type='text/css'' media='screen, projection'/>";
		echo "<style type=\"text/css\">";
		for ($i = 0; $i <$this->_mood_comment_config['tagNumber']; $i++) {
		echo ".sv_image_".($i+1)." { background: url(\"".plugins_url('my-mood-comment/img/').$this->_mood_comment_config['img'][$this->_mood_comment_config['type'][$i]]."\") no-repeat scroll center 0 transparent;}";
		}
		echo "</style>";
        echo "\n".'<!-- Start Of Script Generated By MoodComment '.VERSION.' -->'."\n";

					wp_print_scripts('jquery');

					echo '<script type="text/javascript">'."\n";

					echo '/* <![CDATA[ */'."\n";
					
					echo "function setMycookie(value,name){var Days=1;var exp=new Date();exp.setTime(exp.getTime()+Days*24*3600*1000);document.cookie='".$this->getCookieName($id)."'+\"=\"+escape(value)+\";expires=\"+exp.toGMTString();}";
					echo "\n";
					echo "function updateMoodComment(tag){jQuery.ajax({type:'GET',url:'".plugins_url('my-mood-comment/init.php')."',data:'mood_comment_post_id=".$id."&tag='+tag,cache:false,success:function(data){jQuery('#moodComment').html(data)}});}";

					echo '/* ]]> */'."\n";

					echo '</script>'."\n";

					echo '<!-- End Of Script Generated By MoodComment '.VERSION.' -->'."\n";
    }
	
	public function getCookieName($id){
		if(is_single()) return site_url()."/archives/".$id;
		if(is_page()) return site_url()."/page/".$id;
	}
	
    public function getInitSerialize() {
        return serialize($this->_mood_comment_config['tag']);
    }
	
    public function getMoodCommentDescription($key) {
        $descriptionArray = $this->_mood_comment_config['description'];
        return $descriptionArray[$key];
    }

    public function getCurrentMoodComment($post_id) {
        $mood_comment_meta_arr = get_post_meta($post_id, META_KEY);
        return $mood_comment_meta_arr[0];
    }

    public function getMoodCommentMeta($post_id) {
        $mood_comment_meta = $this->getCurrentMoodComment($post_id);
        if (count($mood_comment_meta) != $this->_mood_comment_config['tagNumber']) {
            add_mood_comment_fields($post_id);
            $mood_comment_meta = unserialize($this->getCurrentMoodComment($post_id));
        }
        return $mood_comment_meta;
    }

    function updateMoodComment() {
        $post_id = $_GET['mood_comment_post_id'];
        $mood_comment_tag = $_GET['tag'];
        $current_mood_comment_meta = $this ->getMoodCommentMeta($post_id);
        $current_mood_comment_meta[$mood_comment_tag] = $current_mood_comment_meta[$mood_comment_tag] + 1;
		
        if (update_post_meta($post_id, META_KEY, serialize($current_mood_comment_meta))) {			
            die($this->updateMoodCommentSuccess($post_id, $mood_comment_tag));
        }
        die(-1);
    }

    function updateMoodCommentSuccess($post_id, $rate_type) {
        return "<h3>你已选择:</h3>" . $this->getMoodCommentUpdatedTemplate($post_id, $rate_type);

    }

    function getMoodCommentUpdatedTemplate($post_id, $moodCommentTag) {
        $buffer = "";
        $count = 0;
        $moodCommentMeta = unserialize($this->getCurrentMoodComment($post_id));
        foreach ($moodCommentMeta as $key => $value) {
            $count++;
            if ($key == $moodCommentTag) {
                $buffer .= "<span class='mc_item selected'>" . $value . 
    	"<span class='sv_image_" . $count . " sv_image'>" . $this->getMoodCommentDescription($key) . "</span></span>";
            }
            else
            {
                $buffer .= "<span class='mc_item'>" . $value .
				"<span class='sv_image_" . $count . " sv_image'>" . $this->getMoodCommentDescription($key) . "</span></span>";

            }
        }
        return $buffer;

    }

    function getOutPutTemplate() {
		$post_id=get_the_ID();
		$moodCommentMeta = unserialize($this->getCurrentMoodComment($post_id));
		$cookie_name=strtr($this->getCookieName($post_id),".","_");
		if(isset($_COOKIE[$cookie_name])){
			return "<div id='moodComment'>".$this->updateMoodCommentSuccess($post_id,$_COOKIE[$cookie_name])."</div>";
		}else{
			$template_header = "<div id='moodComment'><h3>请选择你看完该文章的感受:</h3>";
			$template_body = "";
			for ($i = 0; $i < $this->_mood_comment_config['tagNumber']; $i++) {
				$current_tag=$this->_mood_comment_config['type'][$i];
			
				$template_body .= "<span class='mc_item'>".$moodCommentMeta[$current_tag]."<a class='sv_image_".($i+1)." sv_image' onclick=\"setMycookie('".$current_tag."',".$post_id.");updateMoodComment('".$current_tag."');\" href='javascript:void(0)'>" . $this->_mood_comment_config['description'][$current_tag] . "</a>
                <input type='radio' onclick=\"setMycookie('".$current_tag."',".$post_id.");updateMoodComment('" . $current_tag ."');\"></span>";
				}
			$template_footer = "</div>";
			return $template_header . $template_body . $template_footer;
		}
    }
}