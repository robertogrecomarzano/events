<blockquote>
	<p>Hai una domanda da fare o un dubbio?</p>
	<small>Consulta le risposte alle domande più frequenti, se non trovi
		quello di cui hai bisogno, contatta il supporto tecnico ed <a
		href='{$siteUrl}/p/public/aiuto/ticket'><span class="text-primary">apri
				un ticket per assistenza</span></a>.
	</small>
</blockquote>
{if count($faq)>0}
<div class="panel-body">
	<ul class="list-unstyled timeline">
		{foreach $faq as $f} {if $f@iteration is odd by 1} {assign var="class"
		value=""} {assign var="class_badge" value=""} {else} {assign
		var="class" value="timeline-inverted"} {assign var="class_badge"
		value="primary"} {/if}
		<li class="{$class}">
			<div class="timeline-badge {$class_badge}">
				<i class="fa fa-question"></i>
			</div>
			<div class="timeline-panel">
				<div class="timeline-heading">
					<h4 class="timeline-title">{$f.question}</h4>
				</div>
				<div class="timeline-body">
					<p>{$f.answer}</p>
				</div>
			</div>
		</li> {/foreach}
	</ul>
</div>
{else}
<div class="alert alert-warning">Nessuna Faq al momento disponibile</div>
{/if}
