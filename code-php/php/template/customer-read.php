<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Customer Information Review Page</h1>
    </div>
    <div id="error-area-customer">
        &nbsp;
    </div>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <strong>Firstname: </strong><br>
            <?=ucwords($customerInformation['firstname'])?>
        </div>
        <div class="col-sm-6">
            <strong>Lastname: </strong><br>
            <?=ucwords($customerInformation['lastname'])?>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <strong>Email:</strong>  <?=$email?>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <strong>City: </strong><br>
            <?=ucwords($customerInformation['city'])?>
        </div>
        <div class="col-sm-6">
            <strong>Country: </strong><br>
            <?=ucwords($customerInformation['country'])?>
        </div>
    </div>
    <div class="text-center">
        <strong>Customer Picture: </strong><br/>
        <?php
        ?>
        <div id="profile-picture">
        <img src="uploaded-pictures/<?=$customerPicture?>" alt="Customer Picture" class="profile-picture" />
        </div>
    </div>
    <hr>
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Mini Pocket Calculator</h1>
        <iframe scrolling="no" class="col-lg-12" id="calculator-iframe" style="height: 250px; border: 0px; overflow: hidden;" src="./calculator.php"></iframe>
    </div>
    <hr>
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Screen share utility</h1>
        <button id="0" class="col-lg-12 btn btn-info btn-block">Activate Screen Share</button>
    </div>
</div>