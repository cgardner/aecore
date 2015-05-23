<div>
<span class="pull-right"><a href="#"> Reset All </a></span>
<h4>Filter Options</h4>
<div class="input-group">
            <input type="text" class="form-control input-sm btn-rounded" placeholder="Search">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-default btn-sm btn-rounded"><i class="fa fa-search"></i></button>
            </span>
          </div>
<h5 class="filter-heading">Construction Size</h5>
	<div class="form-group">
          <div class="">
            <input type="text" ui-jq="slider" class="slider form-control" value="" data-slider-min="100" data-slider-max="10000" data-slider-step="100" data-slider-value="[3200,7500]" >
          </div>
 </div>
<h5 class="filter-heading">Budget</h5>
	<div class="form-group">
          <div class="">
            <input type="text" ui-jq="slider" class="slider form-control" value="" data-slider-min="1000" data-slider-max="1000000" data-slider-step="1000" data-slider-value="[320000,550000]" >
          </div>
 </div>
<h5 class="filter-heading">Date Range</h5>
<p>
<form class="form-inline">
  <div class="form-group">
    <label for="startDate">Start Date </label>
    <select ui-jq="select" class="form-control input-sm" style="width: 6em !important">
		  <option value="after">After</option>
		  <option value="before">Before</option>
	</select>
    <input type="text" class="form-control input-sm" style="width: 6em !important" id="StartDate" placeholder="Select">
  </div>
</form>
</p>
<div>
<form class="form-inline">
  <div class="form-group">
    <label for="startDate">End Date </label>
    <select ui-jq="select" class="form-control input-sm" style="width: 6em !important">
		  <option value="after">After</option>
		  <option value="before">Before</option>
	</select>
    <input type="text" class="form-control input-sm" style="width: 6em !important" id="StartDate" placeholder="Select">
  </div>
</form>
</div>
<h5 class="filter-heading">Status</h5>
			<div class="checkbox">
              <label class="i-checks">
                <input type="checkbox" value="">
                <i></i>
	                Open Project
              </label>
            </div>
            <div class="checkbox">
              <label class="i-checks">
                <input type="checkbox" value="">
                <i></i>
	                Closed Project
              </label>
            </div>
            <div class="checkbox">
              <label class="i-checks">
                <input type="checkbox" value="">
                <i></i>
	                Archived Project
              </label>
            </div>

<h5 class="filter-heading">Collabrators</h5>
<div class="m-b m-t-lg">
        <a href="" class="avatar thumb-xs m-r-xs">
          <img src="http://placehold.it/48" alt="...">
          <i class="on b-white"></i>
        </a>
        <a href="" class="avatar thumb-xs m-r-xs">
          <img src="http://placehold.it/48" alt="...">
          <i class="busy b-white"></i>
        </a>
        <a href="" class="avatar thumb-xs m-r-xs">
          <img src="http://placehold.it/48" alt="...">
          <i class="away b-white"></i>
        </a>
        <a href="" class="avatar thumb-xs m-r-xs">
          <img src="http://placehold.it/48g" alt="...">
          <i class="on b-white"></i>
        </a>
      </div>
<h5 class="filter-heading">Tags</h5>
<div>
<form class="form-inline">
  <div class="form-group">
    <select ui-jq="select" class="form-control input-sm" style="width: 6em !important">
		  <option value="is">is</option>
		  <option value="inn't">isn't</option>
	</select>
    <input type="text" class="form-control input-sm" style="width: 10em !important" id="StartDate" placeholder="Select">
  </div>
</form>
</div>
</div>

</script>