<% if $Violators %>
<% loop $Violators %>
<div id="violator-{$ID}" class="violators__violator top4">
    <div class="violator-content">
        <div class="violator-text">
            $Content
        </div>
    </div>
</div>
<% end_loop %>
<% end_if %>
