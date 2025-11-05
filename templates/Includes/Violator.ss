<% if $Violators %>
    <% loop $Violators %>
        <% set $violatorClass = "violators__violator container-fluid text-center alert alert-warning alert-dismissible mb-0 border-top-0 border-end-0 border-start-0 rounded-0" %>
        <% if $Last %>
            <% set $violatorClass = "$violatorClass border-bottom-0" %>
        <% end_if %>
        <div id="violator-{$ID}" class="$violatorClass" role="alert"<% if $ShowOnce %> data-cookiename="$CookieName"<% end_if %>>
            <strong>$Title</strong>
            <div class="violator-text">
                $Content
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <% end_loop %>
<% end_if %>
