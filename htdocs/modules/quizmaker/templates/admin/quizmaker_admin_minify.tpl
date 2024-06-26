<!-- Header -->
<{include file='db:quizmaker_admin_header.tpl' }>

<{if $actions_list}>
<form name="form" id="form_minify" action="minify.php?op=list" method="post" enctype="multipart/form-data">
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_QUIZMAKER_CODE}></th>
				<th class="center"><{$smarty.const._AM_QUIZMAKER_DESCRIPTION}></th>
				<th class="center"><{$smarty.const._AM_QUIZMAKER_IS_MINIFED}></th>
				<th class="center"><{$smarty.const._AM_QUIZMAKER_ACTIONS}></th>
			</tr>
		</thead>
		<tbody>
			<{foreach item=Action from=$actions_list name=actions key=code}>
            
              <{if $code == $smarty.const.QUIZMAKER_ALL}>
                <{assign var="styleParent" value="style='background:navajowhite;'"}>
              <{elseif $code == 'plugins'}>
                <{assign var="styleParent" value="style='background:lightblue;'"}>
              <{else}>
                <{assign var="styleParent" value=""}>
              <{/if}>
            
			<tr class='<{cycle values='odd, even'}>' <{$styleParent}>>
				<td class='left' <{$styleParent}> ><{$code}></td>
				<td class='left' <{$styleParent}> ><{$Action.desc}></td>
				<td class='center' <{$styleParent}> >
                    <{* $Action.isMinified *}>
                  <{if $Action.isMinified}>
                      <img src="<{$modPathNotes}>/004.png" alt='' title=''>
                  <{else}>
                      <img src="<{$modPathNotes}>/000.png" alt='' title=''>
                  <{/if}>
                </td>
				<td class='center' <{$styleParent}> >
<input type="submit" class="formbutton" name="action[<{$code}>][restaure]" id="action[<{$code}>][restaure]" value="<{$smarty.const._AM_QUIZMAKER_TOOLS_RESTAURE}>" style='width:150px;'>                
<input type="submit" class="formbutton" name="action[<{$code}>][minifie]"  id="action[<{$code}>][minifie]"  value="<{$smarty.const._AM_QUIZMAKER_TOOLS_MINIFIER}>" style='width:150px;'>                
                </td>
			</tr>
			<{/foreach}>
		</tbody>
	</table>
</form> 
<{/if}>





<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{*  ----------------------------------------------
*}> 

<!-- Footer -->
<{include file='db:quizmaker_admin_footer.tpl' }>
