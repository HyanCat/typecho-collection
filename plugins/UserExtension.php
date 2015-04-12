<?php
/**
 * 博客扩展插件
 *   - 设置用户头像，不使用Gavatar
 *   - 添加自定义页脚
 *
 * @package UserExtension
 * @author HyanCat
 * @version 0.0.1
 * @link http://hyancat.com
 */
class UserExtension implements Typecho_Plugin_Interface
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
        Typecho_Plugin::factory('Widget_Archive')->footer = array('UserExtension', 'addFooter');
        return "插件启用成功，请进行设置";
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
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $user_head_label = new Typecho_Widget_Helper_Form_Element_Radio('text', NULL, '',
            _t('设置头像：'));
        $form->addInput($user_head_label);
        $user_head_text = new Typecho_Widget_Helper_Form_Element_Text('head', NULL, '', '');
        $form->addInput($user_head_text);

        $footer_label = new Typecho_Widget_Helper_Form_Element_Radio('text', NULL, '',
            _t('添加页底：'));
        $form->addInput($footer_label);
        $footer_area = new Typecho_Widget_Helper_Form_Element_Textarea('footer', NULL, '', '');
        $form->addInput($footer_area);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 添加footer
     */
    public static function addFooter()
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('UserExtension');
        echo $options->footer;
    }

}
