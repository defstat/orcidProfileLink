{**
 * plugins/generic/orcidProfileLink/orcidIssue.tpl
 *
 * Copyright (c) National Documentation Centre
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * ORCID Link addition to Article View Page
 *
 *}
<script type="text/javascript">

	$(function() {ldelim}
		$("#authorString").hide();
	{rdelim})
</script>

<div id="authorStringOrcid">
	<em>{$authorStringOrcid}</em>
</div>