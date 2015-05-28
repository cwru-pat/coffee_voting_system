<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        <div class="input-group input-group-lg">
          <input type="text" class="form-control" id="arxiv_search" placeholder="Search...">
          <div class="input-group-addon">
            <select id="arxiv_search_order" class="form-control input-sm">
              <option value="relevance">Sort by Relevance</option>
              <option value="lastUpdatedDate">Sort by Date</option>
            </select>
          </div>
        </div>

      </div> <!-- modal header -->
      <div class="modal-body">
        <div id="arxiv_search_results"></div>
      </div>
    </div>
  </div>
</div>
