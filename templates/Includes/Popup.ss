<% if $PopUps %>
    <% loop $PopUps.Limit(1) %>
        <!-- Modal -->
        <div class="popup__modal modal fade" id="modal-{$ID}"  tabindex="-1" aria-labelledby="modal-{$ID}-title" aria-hidden="true"<% if $ShowOnce %> data-cookiename="$CookieName"<% end_if %> data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-{$ID}-title">$Title</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <% if $Image %>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="$Image.URL" alt="$Image.Title" class="img-fluid">
                                    </div>
                                    <div class="col-md-6">
                                        $Content
                                    </div>
                                </div>
                            </div>
                        <% else %>
                            $Content
                        <% end_if %>

                    </div>
                    <% if $ContentLink %>
                        <div class="modal-footer">
                            <a href="$ContentLink.URL"<% if $OpenInNewWindow %> target="_blank"<% end_if %> type="button" class="btn btn-primary">$ContentLink.Title</a>
                        </div>
                    <% end_if %>
                </div>
            </div>
        </div>
    <% end_loop %>
<% end_if %>
