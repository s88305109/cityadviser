<div class="card">
	<div class="card-body">
		管理公司及員工資料
	</div>
</div>
<!--
<div class="text-center mt-2">
	<a class="btn btn-primary" href="/organization">進入組織管理</a>
</div>
-->

@if (Auth::user()->hasPermission('employee') & ! Auth::user()->hasPermission('company')) 
<div class="text-center mt-2">
	<a class="btn btn-primary" href="/organization/employee">進入組織管理</a>
</div>
@elseif (! Auth::user()->hasPermission('employee') & Auth::user()->hasPermission('company')) 
<div class="text-center mt-2">
	<a class="btn btn-primary" href="/organization/company">進入組織管理</a>
</div>
@else
<div class="text-center mt-2">
	<a class="btn btn-primary" href="/organization">進入組織管理</a>
</div>
@endif
