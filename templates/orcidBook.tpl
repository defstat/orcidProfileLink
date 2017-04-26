{**
 * plugins/generic/orcidProfileLink/orcidArticle.tpl
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

<div id="orcidProfileLinkPlugin-authors" class="item authors">
	{foreach from=$publishedMonograph->getAuthors() item=author}
		{if $author->getIncludeInBrowse()}
			<div class="sub_item">
				<div class="label">
					{$author->getFullName()|escape}
                    {if $author->getData('orcid')}
                        <a target="_blank" href="{$author->getData('orcid')}"><img src="{$baseUrl}/plugins/generic/orcidProfileLink/templates/images/orcid_16x16.png" /></a>
                    {/if}
				</div>
				<div class="value">
					<div class="role">
						{$author->getLocalizedUserGroupName()|escape}
					</div>
					{assign var=biography value=$author->getLocalizedBiography()|strip_unsafe_html}
					{if $biography}
						<div class="bio">
							{$biography|strip_unsafe_html}
						</div>
					{/if}
				</div>
			</div>
		{/if}
	{/foreach}
</div>
