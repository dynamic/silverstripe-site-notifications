<% if $Violators %>
<% loop $Violators %>
<div id="violator-{$ID}" class="violators__violator container-fluid text-center" role="alert"<% if $ShowOnce %> data-cookiename="$CookieName"<% end_if %>>
    <strong>$Title</strong><br>
    <div class="violator-textn">
        $Content
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<% end_loop %>
<% end_if %>
