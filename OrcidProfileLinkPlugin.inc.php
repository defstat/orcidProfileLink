<?php

/**
 * @file plugins/generic/orcidProfile/OrcidProfileLinkPlugin.inc.php
 *
 * Copyright (c) National Documentation Centre
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class OrcidProfilePluginView
 * @ingroup plugins_generic_orcidProfileLink
 *
 * @brief ORCID Profile View plugin class
 */

import('lib.pkp.classes.plugins.GenericPlugin');

define('ORCID_PROFILE_URL_PREFIX', 'https://orcid.org/');

class OrcidProfileLinkPlugin extends GenericPlugin {
    public $array = [];

	/**
	 * Called as a plugin is registered to the registry
	 * @param $category String Name of category plugin was registered to
	 * @return boolean True iff plugin initialized successfully; if false,
	 * 	the plugin will not be registered.
	 */
	function register($category, $path) {
		$success = parent::register($category, $path);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
		if ($success && $this->getEnabled()) {
			// Register callback for Smarty filters; add CSS
            HookRegistry::register('TemplateManager::display', array(&$this, 'handleTemplateDisplay'));

		}

		return $success;
	}

    /**
     * Hook callback: register output filter to add data citation to submission
     * summaries; add data citation to reading tools' suppfiles and metadata views.
     * @see TemplateManager::display()
     */
	function handleTemplateDisplay($hookName, $args) {
		$templateMgr =& $args[0];
		$template =& $args[1];
        $request =& PKPApplication::getRequest();

		switch ($template) {
			case 'article/article.tpl':
				$templateMgr->register_outputfilter(array(&$this, 'templateArticleFilter'));
				break;
		}
		return false;
	}

    /**
     * Output filter adds ORCiD profile link to article view page.
     * @param $output string
     * @param $templateMgr TemplateManager
     * @return $string
     */
	function templateArticleFilter($output, &$templateMgr) {
		if (preg_match('/<div id="authorString"+>/', $output, $matches, PREG_OFFSET_CAPTURE)) {
			$offset = $matches[0][1];

            // Make the author string with it's ORCID link.
            $article = $templateMgr->get_template_vars('article');
            $str = $this->getAuthorNameWithOrcid($article);

			$templateMgr->assign(array(
				'authorStringOrcid' => $str,
			));

			$newOutput = substr($output, 0, $offset);
			$newOutput .= $templateMgr->fetch($this->getTemplatePath() . 'orcidArticle.tpl');
			$newOutput .= substr($output, $offset);
			$output = $newOutput;
		}
		$templateMgr->unregister_outputfilter('templateArticleFilter');
		return $output;
	}

    function getAuthorNameWithOrcid($article) {
        $authors = $article->getAuthors();

        $str = '';
        foreach($authors as $author) {
            if (!empty($str)) {
                $str .= ', ';
            }

            if ($author->getData('orcid') && $author->getData('orcid') != "") {
                $str .= htmlspecialchars($author->getFullName()).' (<a target="_blank" href="'.$author->getData('orcid').'">'.$author->getData('orcid').'</a>)';
            } else {
                $str .= htmlspecialchars($author->getFullName());
            }
        }

        return $str;
    }

	/**
	 * @copydoc Plugin::getDisplayName()
	 */
	function getDisplayName() {
		return __('plugins.generic.orcidProfileLink.displayName');
	}

	/**
	 * @copydoc Plugin::getDescription()
	 */
	function getDescription() {
		return __('plugins.generic.orcidProfileLink.description');
	}

	/**
	 * Extend the {url ...} smarty to support this plugin.
	 */
	function smartyPluginUrl($params, &$smarty) {
		$path = array($this->getCategory(), $this->getName());
		if (is_array($params['path'])) {
			$params['path'] = array_merge($path, $params['path']);
		} elseif (!empty($params['path'])) {
			$params['path'] = array_merge($path, array($params['path']));
		} else {
			$params['path'] = $path;
		}

		if (!empty($params['id'])) {
			$params['path'] = array_merge($params['path'], array($params['id']));
			unset($params['id']);
		}
		return $smarty->smartyUrl($params, $smarty);
	}

	/**
	 * Set the page's breadcrumbs, given the plugin's tree of items
	 * to append.
	 * @param $subclass boolean
	 */
	function setBreadcrumbs($isSubclass = false) {
		$templateMgr =& TemplateManager::getManager();
		$pageCrumbs = array(
			array(
				Request::url(null, 'user'),
				'navigation.user'
			),
			array(
				Request::url(null, 'manager'),
				'user.role.manager'
			)
		);
		if ($isSubclass) {
			$pageCrumbs[] = array(
				Request::url(null, 'manager', 'plugins'),
				'manager.plugins'
			);
			$pageCrumbs[] = array(
				Request::url(null, 'manager', 'plugins', 'generic'),
				'plugins.categories.generic'
			);
		}

		$templateMgr->assign('pageHierarchy', $pageCrumbs);
	}
}
?>
