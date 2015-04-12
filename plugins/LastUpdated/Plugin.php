<?php
/**
 * 列出最近更新的文章
 * 
 * @package LastUpdated 
 * @author cgrabbit
 * @version 1.0.0
 * @update: 2012.08.22
 * @link http://www.cgrabbit.info
 */
class LastUpdated_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
		Typecho_Plugin::factory('Widget_Contents_Post_Edit')->write = array('LastUpdated_Plugin', 'lastEdit');
		
		$db = Typecho_Db::get();
		$last = $db->fetchRow($db->select()->from('table.options')->where('`name` = ?', 'lastUpdated'));
		if($last==null){
			$args = array();
			$args = serialize($args);
			$db->query($db->insert('table.options')->rows(array('name' => 'lastUpdated', 'user' => 0, 'value' => $args)));
		}
		return "插件激活成功";
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){}

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

	
    /**
     * 更新数据
     *
     * 
     * @return void
     */
	public static function lastEdit($content)
	{	
		$db = Typecho_Db::get();
		Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
		$N = 8;
		$cid = $post->cid;
		$options = Typecho_Widget::widget('Widget_Options');
		if($cid!=null && $cid>0){
			$lastUpdated = unserialize($options->lastUpdated);
			$new = array();
			$new['title'] = $post->title;
			$new['link'] = $post->permalink;
			$new['time'] = date('Y/m/d H:i:s',time()+60*60*8);
			foreach($lastUpdated as $key => $val){
				if($new['title'] == $val['title'] || $new['link'] == $val['link']){
					unset($lastUpdated[$key]); 
					break;
				}
			}
			array_push($lastUpdated, $new);
			if(count($lastUpdated)>$N) array_shift($lastUpdated);  
			$args = serialize($lastUpdated);
			$db->query($db->update('table.options')->rows(array('value' => $args))->where('name = ?', 'lastUpdated'));
		}
		return $content;
	}
	/**
     * 输出最新更新的文章
     *
     * 语法: LastUpdated_Plugin::lastUpdated();
     *
     * @access public
     * @return void
     */
    public function lastUpdated()
	{
		$options = Typecho_Widget::widget('Widget_Options');
		$N = 8;
		$last = $options->lastUpdated;
		$last = unserialize($last);
		$cnt = count($last);
		if($cnt>0){
			$n=0;
			echo '<div id="lastUpdated" class="widget"><ul class="listupdated">';
			foreach(array_reverse($last) AS $value){
				$n++;
				if($n>$N) break;
				echo '<li><a href="'.$value['link'].'" title="'.$value['title'].'">'.$value['title'].'</a><span class="modified">修改时间:'.$value['time'].'</span></li>';
			}
			echo '</ul></div>';
		}
	}
}
