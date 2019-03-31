<div class="p-5">
    <div class="text-center">
    <h1 class="h4 text-gray-900 mb-4">Customer Information Entry</h1>
    </div>
    <div id="error-area-customer">
    &nbsp;
    </div>
    <form class="form-customer" action="" >
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="text" class="form-control form-control-user" name="firstname" id="firstname" placeholder="First Name">
        </div>
        <div class="col-sm-6">
        <input type="text" class="form-control form-control-user" name="lastname" id="lastname" placeholder="Last Name">
        </div>
    </div>
    <div class="form-group">
        <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Email Address">
    </div>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="text" class="form-control form-control-user" id="city" name="city" placeholder="City">
        </div>
        <div class="col-sm-6">
        <select id="country" name="country" class=" custom-select custom-select-lg mb-3">
            <option value="0">Please select country</option>
            <option value="canada">Canada</option>
            <option value="france">France</option>
            <option value="germany">Germany</option>
            <option value="japan">Japan</option>
            <option value="united states">United States</option>
            <option value="united kingdom">United Kingdom</option>
        </select>
        </div>
    </div>
    
    <div class="text-center">
        Customer Picture: <br/>
        <?php
        ?>
        <div id="profile-picture">
        <img src="uploaded-pictures/<?=$customerPicture?>" alt="Customer Picture" class="profile-picture" />
        </div>
        <input type="hidden" name="uploaded-image" id="uploaded-image" value="<?=$customerPicture?>" />
        <br>
        <button type="button" id="upload-picture"  class="btn btn-primary btn-user"  data-toggle="modal" data-target="#uploadModal">Upload</button>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="reset" class="btn btn-secondary btn-user btn-block" id="reset-button">
        </div>
        <div class="col-sm-6">
        <button type="button" id="save-form" class="btn btn-primary btn-user btn-block">Save</button>
        </div>
    </div>
    
    <hr>
    </form>
    <hr>
    
</div>