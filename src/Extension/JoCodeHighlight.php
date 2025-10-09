<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.JoCodeHighlight
 * @copyright   (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
                (C) 2025 JL TRYOEN <https://www.jltryoen.fr>
 *
 * Version 1.0.0
 *
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 * @link        https://www.jltryoen.fr
*/

namespace JLTRY\Plugin\Content\JOCodeHighlight\Extension;

use Joomla\CMS\Event\Content\ContentPrepareEvent;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Utility\Utility;
use Joomla\Event\SubscriberInterface;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * JOCodeHighlight Content Plugin
 *
 * @package     Joomla.Plugin
 * @subpackage  Content.JOCodeHighlight
 */
class JOCodeHighlight extends CMSPlugin implements SubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'onContentPrepare'  => 'onContentPrepare'
        ];
    }

    /**
     * @param   string    The context of the content being passed to the plugin.
     * @param   object    The article object.  Note $article->text is also available
     * @param   object    The article params
     * @param   integer  The 'page' number
     */
    public function onContentPrepare(ContentPrepareEvent $event)
    {
        //Escape fast
        if (!$this->getApplication()->isClient('site')) {
            return;
        }

        if (!$this->params->get('enabled', 1)) {
            return true;
        }
        // use this format to get the arguments for both Joomla 4 and Joomla 5
        // In Joomla 4 a generic Event is passed
        // In Joomla 5 a concrete ContentPrepareEvent is passed
        [$context, $article, $params, $page] = array_values($event->getArguments());
        // Simple performance check to determine whether bot should process further.
        if (strpos($article->text, 'pre>') === false)
        {
            return true;
        }

        // Define the regular expression for the bot.
        $regex = "#<pre xml:\s*(.*?)>(.*?)</pre>#s";

        // Perform the replacement.
        $article->text = preg_replace_callback($regex, array(&$this, '_replace'), $article->text);

        return true;
    }

    /**
     * Replaces the matched tags.
     *
     * @param   array  An array of matches (see preg_match_all)
     * @return  string
     */
    protected function _replace($matches)
    {

        require_once __DIR__ . '/../../geshi/src/geshi.php';

        $args = Utility::parseAttributes($matches[1]);
        $text = $matches[2];

        $lang = ArrayHelper::getValue($args, 'lang', 'php');
        $lines = ArrayHelper::getValue($args, 'lines', 'false');

        $html_entities_match = array("|\<br \/\>|", "#<#", "#>#", "|&#39;|", '#&quot;#', '#&nbsp;#');
        $html_entities_replace = array("\n", '&lt;', '&gt;', "'", '"', ' ');

        $text = preg_replace($html_entities_match, $html_entities_replace, $text);

        $text = str_replace('&lt;', '<', $text);
        $text = str_replace('&gt;', '>', $text);

        $text = str_replace("\t", '  ', $text);
        
        $text = ltrim(rtrim( $text ));
        
        $geshi = new \GeSHi($text, $lang);
        if ($lines == 'true')
        {
            $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
        }
        $geshi->set_header_type(GESHI_HEADER_DIV);
        $geshi->set_overall_class('mw-geshi');
        $geshi->set_code_style('font-family:monospace;font-size: 13px;line-height: normal;', true);        
        $text = $geshi->parse_code();
        
        return $text;
    }
}
