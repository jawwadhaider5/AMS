<style>
  .hidden {
    display: none;
  }
</style>

<!--<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme @if(Route::currentRouteName() != 'all-system' || !Route::is('save-systemtype-id/*') ) hidden @endif" style="background: #89CFF0!important;">-->

<!--ch -->
@php
// Get the current route name
$currentRouteName = Route::currentRouteName();

// Initialize the flag for save-systemtype-id
$isSaveSystemTypeId = 'false';

// Check if the current route matches save-systemtype-id/{id} and extract the id
if ( $currentRouteName == 'save-systemtype-id' ) {
$isSaveSystemTypeId = 'true';
}
@endphp
@if(Route::currentRouteName() === 'dashboard')
<aside id="layout-menu" class="layout-menu menu-vertical d-none menu bg-menu-theme" style="background: #89CFF0!important; overflow-y: scroll;">
  @else
  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background: #89CFF0!important; overflow-y: scroll;">
    @endif
    <!-- Your sidebar content -->


    <!-- Your sidebar content -->



    <!--<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme   " style="background: #89CFF0!important;">-->

    <!---->
    <?php

    use App\Models\Category;
    use App\Models\System;
    use App\Models\SystemType;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $systemtypes = System::with('systemtype')->get();
    $categories = Category::with('subcategories')->get();
    ?>

    <div class="app-brand demo">
      <a href="{{route('dashboard')}}" class="app-brand-link py-5">
        <img src="{{asset('assets/logo/1.jpeg')}}" class="w-50 m-auto d-block">
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>
    <div class="mx-3 mb-2" style="
    background: white;
    border-radius: 5px;
">
      <select id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true">
        @foreach ($systemtypes as $systemtype)
        <option value="{{$systemtype->id}}">{{$systemtype->system_name}} - {{$systemtype->systemtype->name}}</option>
        @endforeach
      </select>
    </div>

    <ul id="menuContainer" class="list-unstyled">

    </ul>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">


      <li class="menu-header small text-uppercase">
        <span class="menu-header-text text-dark fw-bold">Advance Options</span>
      </li>

      @can('all spread type')
      <li class="menu-item {{ Request::is('systemtype/all') || Request::is('systemtype/add') ? 'active' : '' }}">
        <a href="{{route('all-systemtype')}}" class="menu-link">
          <div>Spread Type</div>
        </a> 
      </li>

      
      @endcan


      @can('all task type')
      <li class="menu-item {{ Request::is('tasktype/all') ||  Request::is('tasktype/add') ? 'active' : '' }}">
        <a href="{{route('all-tasktype')}}" class="menu-link">
          <div>Task Type</div>
        </a>
      </li>
      @endcan

      @can('all pre define task')
      <li class="menu-item {{ Request::is('pretask/all') || Request::is('pretask/add') ? 'active' : '' }}">
        <a href="{{route('all-pretask')}}" class="menu-link">
          <div>Predefine Task</div>
        </a>
      </li>
      @endcan
      @can('all imca reference')
      <li class="menu-item {{ Request::is('imca/all') || Request::is('imca/add') ? 'active' : '' }}">
        <a href="{{route('all-imca')}}" class="menu-link">
          <div>IMCA Reference</div>
        </a>
      </li>
      @endcan

      @can('roles and permission')
      <li class="menu-item {{ Request::is('roles') || Request::is('permissions') ? 'open' : '' }}">
        <a class=" menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-settings"></i>
          <div data-i18n="Roles & Permissions">Roles & Permissions</div>
        </a>
        <ul class="menu-sub">
          @can('all role')
          <li class="menu-item {{ Request::is('roles') ? 'active' : '' }}">
            <a href="{{route('roles.index')}}" class="menu-link">
              <div data-i18n="Roles">Roles</div>
            </a>
          </li>
          @endcan
          @can('all permission')
          <li class="menu-item {{ Request::is('permissions') ? 'active' : '' }}">
            <a href="{{route('permissions.index')}}" class="menu-link">
              <div data-i18n="Permission">Permission</div>
            </a>
          </li>
          @endcan
          @can('all user')
          <li class="menu-item {{ Request::is('users') ? 'active' : '' }}">
            <a href="{{route('users.index')}}" class="menu-link">
              <div data-i18n="Users">Users</div>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcan

      <li class="menu-item {{ Request::is('edit-profile') ? 'active' : '' }}">
        <a href="{{route('edit_profile')}}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-mail"></i>
          <div>Edit porfile</div>
        </a>
      </li>


      @can('setting')
      <li class="menu-item">
        <a href="{{route('setting')}}" class="menu-link ">
          <i class="menu-icon tf-icons ti ti-settings"></i>
          <div>Settings</div>
        </a>
      </li>
      @endcan

    </ul>
  </aside>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#select2Basic').select2();

      function getSessionSystemTypeId() {
        var systemtypeId = 1;
        $.ajax({
          url: '/get-systemtype-id',
          method: 'GET',
          async: false,
          success: function(response) {
            if (response.systemtype_id !== null) {
              systemtypeId = response.systemtype_id;
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
        return systemtypeId;
      }

      var systemtypeId = getSessionSystemTypeId();
      $('#select2Basic').val(systemtypeId).trigger('change');

      loadCategories(systemtypeId);

      $('#select2Basic').on('change', function() {

        systemtypeId = $(this).val();

        $.ajax({
          url: '/set-systemtype-id',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            systemtype_id: systemtypeId
          },
          success: function(response) {
            window.location.reload();
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });


      });

      function loadCategories(systemtypeId) {
        $.ajax({
          url: '/categories-update',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            systemtype_id: systemtypeId
          },
          success: function(response) {
            if (response.success) {
              updateCategories(response.categories);
            } else {
              console.error('Error fetching categories');
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
      }

      function updateCategories(categories) {
        var menuContainer = $('#menuContainer');
        menuContainer.empty();
        var currentUrl = window.location.pathname;

        categories.forEach(function(category) {
          var isCategoryOpen = category.subcategories.some(function(subcategory) {
            return currentUrl.includes('/assets/subcategory/' + subcategory.id);
          });

          var categoryItem = $('<li>').addClass('menu-item' + (isCategoryOpen ? ' open' : ''));
          var categoryLink = $('<a>').addClass('menu-link menu-toggle')
            .append('<i class="menu-icon tf-icons ti ti-color-swatch"></i>')
            .append('<div>' + category.name + '</div>');
          categoryItem.append(categoryLink);

          var subcategoryList = $('<ul>').addClass('menu-sub' + (isCategoryOpen ? ' open' : ''));
          category.subcategories.forEach(function(subcategory) {
            var baseUrl = window.location.protocol + '//' + window.location.host + '/';
            var subcategoryUrl = baseUrl + 'assets/subcategory/' + subcategory.id;
            var isSubcategoryActive = currentUrl.includes('/assets/subcategory/' + subcategory.id);

            var subcategoryItem = $('<li>').addClass('menu-item' + (isSubcategoryActive ? ' active' : ''));
            var subcategoryLink = $('<a>').addClass('menu-link').attr('href', subcategoryUrl)
              .append('<div style="width:100%">' + subcategory.name + '<span style="float:right;">(' + subcategory.assetCount + ')</span></div>');
            subcategoryItem.append(subcategoryLink);
            subcategoryList.append(subcategoryItem);
          });

          var addSubCategoryButton = $('<button>')
            .addClass('btn btn-primary add-sub-category-button')
            .html('<i class="fas fa-plus me-2"> </i>  Sub-Category')
            .on('click', function() {

              $('#addSubCategoryModal').data('categoryId', category.id).modal('show');
            });
          var addSubCategoryContainer = $('<li>').addClass('menu-item add-sub-category-container').append(addSubCategoryButton);
          subcategoryList.append(addSubCategoryContainer);
          categoryItem.append(subcategoryList);
          menuContainer.append(categoryItem);
        });
      }


      var modalHtml = `
  <div class="modal fade" id="addSubCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addSubCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSubCategoryModalLabel">Add Sub Component</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addSubCategoryForm">
            <div class="form-group">
              <label for="subcategoryName">Sub Component Name</label>
              <input type="text" class="form-control" id="subcategoryName" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Add</button>
          </form>
        </div>
      </div>
    </div>
  </div>`;

      $('body').append(modalHtml);

      var csrfToken = $('meta[name="csrf-token"]').attr('content');

      $('#addSubCategoryForm').on('submit', function(event) {
        event.preventDefault();
        var categoryId = $('#addSubCategoryModal').data('categoryId');
        var subcategoryName = $('#subcategoryName').val();
        $.ajax({
          url: '/addsubcategory',
          type: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken
          },
          data: {
            categoryId: categoryId,
            name: subcategoryName
          },
          success: function(response) {
            if (response.success) {
              alert('Sub Component added successfully!');
              window.location.reload();
            } else {
              alert('Error adding subcategory');
            }
          },
          error: function(xhr, status, error) {
            alert('An error occurred: ' + error);
          }
        });
        $('#addSubCategoryModal').modal('hide');
      });

    });
  </script>