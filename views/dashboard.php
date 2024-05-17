<?php

    $categories = $_SESSION['categories'];
    $corpse = $_SESSION['corpse'] ?? [];

    $total_corpse = count($_SESSION['all_corpse']);
    $males = $females = $vip = $vvip = $standard = $young = $adult = 0;

    function age($dob, $dod){
        $yob = (int)explode('-', $dob)[0];
        $yod = (int)explode('-', $dod)[0];

        return $yod-$yob;
    }

    foreach($_SESSION['all_corpse'] as $corp){
        extract($corp);

        ($gender === 'M') ? $males++ : $females++;
        (age($DOB, $DOD) <= 18) ? $young++ : $adult++;

        if($cat_name === 'VIP'){
            $vip++;
        }elseif($cat_name === 'VVIP'){
            $vvip++;
        }else{
            $standard++;
        }
  
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="assets/css/dashboard.css">
    <!-- link to font icons -->
    <link rel="stylesheet" href="assets/font/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
    <header class='header'>
        <h2>Dashboard</h2>

        <div class='header_search'>  
        <form action="" method="POST">
            <input type="hidden" name="option" value="search">
            <input type="text" placeholder="Search for corpse by name" name="search" /> 
            <button type="submit">
                <i class="fas fa-search" title="search"></i>
            </button>  
        </form>  
        </div>

        <button disabled={true} class='notif_btn'>
            <i class="fas fa-bell" title="cart" id="cart">
                <span id="pd_qnty_num">
                2
                </span>
            </i>
        </button>

        <a href="/logout" class="logout">
            <i class="fas fa-power-off"></i>
            <span>
                Logout
            </span>
        </a>

    </header>

    <nav>
        <div class="section1">
            <h3 class="title">
                Display Options
            </h3>
    
            <div>
                <h3>
                    Category
                </h3>
                <?php
                    if($categories){
                        foreach($categories as $cat){
                ?>
                <form action="" method="POST">
                    <input type="hidden" name="option" value="order">

                    <input type="hidden" name="order_by_cat" value="<?=$cat['cat_id']?>">
                    <input type="submit" name="category" value="<?=$cat['cat_name']?>">
                </form>
                <?php
                    } }
                ?>
                    
            </div>
            <div>
                <h3>
                    Date of Death
                </h3>
                <form action="" method="POST">
                    <input type="hidden" name="option" value="order">
                    <input type="hidden" name="order_by_date" value="date">
                    <input type="submit" name="asc" value="ASC">
                    <input type="submit" name="dsc" value="DSC">
                </form>
            
            </div>
            <div>
                <h3>
                    Sex
                </h3>
                <form action="" method="POST">
                    <input type="hidden" name="option" value="order">
                    <input type="hidden" name="order_by_sex" value="date">
                    <input type="submit" name="female" value="Females">
                    <input type="submit" name="male" value="Males">

                </form>
            
            </div>
        </div>

        <div class="section2">
            <h3>
                Overall Records
            </h3>
            <table>
                <tr>
                    <th colspan="2"> Total </th>
                    <th><?=$total_corpse?></th>
                </tr>
                <tr>
                    <th rowspan="2">Sex</th>
                    <td>Males</td>
                    <td><?=$males?></td>
                </tr>
                <tr>
                    <td>Females</td>
                    <td><?=$females?></td>
                </tr> 
                <tr>
                    <th rowspan="2">Age</th>
                    <td>18 --</td>
                    <td> <?=$young?> </td>
                </tr> 
                <tr>
                    <td>19 ++</td>
                    <td> <?=$adult?> </td>
                </tr> 
                <tr>
                    <th rowspan="3">Category</th>
                    <td>V-VIP</td>
                    <td><?=$vvip?></td>
                </tr> 
                <tr>
                    <td>Standard</td>
                    <td><?=$standard?></td>
                </tr> 
                <tr>
                    <td>VIP</td>
                    <td> <?=$vip?> </td>
                </tr>
                
            </table>
        </div>
    </nav>

    <main >
        <h3>List of Deceased Individuals <span>(All)</span></h3>
        <span class="addFile">
            Add Corpse
        </span>

        <?php
            if(isset($_SESSION['dash_msg'])){
                $msg = $_SESSION['dash_msg'];
                if($msg['status']){
                    echo '<span class="msg success">'.$msg['msg'].'</span>';
                }
                else{
                    echo '<span class="msg error">'.$msg['msg'].'</span>';
                }
                
                unset($_SESSION['dash_msg']);
            }
        ?>
        <div class="table-section">
            <table>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Date of Death</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                
                <?php 
                    if($corpse){
                    foreach($corpse as $cor): 
                ?>
                    <tr>
                        <td>
                            <img src="assets/images/<?= $cor['picture']?>" alt="">
                        </td>
                        <td> <?= $cor['fname']?> </td>
                        <td> <?= $cor['DOD']?></td>
                        <td> <?= $cor['cat_name']?></td>

                        <td class="link">
                            <form action="" method="POST">
                                <input type="submit" name="view" value="View" data-corID="<?=$cor['id']?>" id="aside_btn">
                                
                                <input type="submit" name="delete" value="Remove">
                                <input type="hidden" name="option" value="delete">
                                <input type="hidden" name="hiddenID" value="<?=$cor['id']?>">

                            </form>
                        </td>     
                    </tr>
                <?php endforeach;
                    }else{
                ?>
                    <tr>
                        <td colspan="5"> No Record(s) Found</td>
                    </tr>
                <?php
                }
                ?>

            </table>
        </div>
    </main>

    <aside>
        <div class="close-btn" title="close" id="aside">
            <i class="fas fa-x"></i>
        </div>

        <div class="img_sec">
            <img src="assets/images/test.jpg" alt="" id="picture">
        </div>
        <p>Deceased ID : <span id="id">sometext</span> </p>
        <p>First Name : <span id="fname">sometext</span> </p>
        <p>Last Name : <span id="lname">sometext</span> </p>
        <p>Gender : <span id="gender">sometext</span> </p>
        <p>Occupation : <span id="occupation">sometext</span> </p>
        <p>Died At : <span id="age">sometext</span> </p>
        <p>Category : <span id="cat_name">sometext</span> </p>
        <p>Price/day : <span id="price">sometext</span> </p>
        <p>Guardian : <span id="guardian_name">sometext</span> </p>
        <p>Guardian Email : <span id="guardian_email">sometext</span> </p>
        <p>Marital Status : <span id="marital_status">sometext</span> </p>
        <p>Date of Birth : <span id="DOB">sometext</span> </p>
        <p>Mortuary Duration(days) so far : <span id="duration">sometext</span> </p>
        <p>Mortuary Duration(days) : <span id="dur">sometext</span> </p>
        <p>Total price : <span id="total_price">sometext</span>k  frs </p>
        <p>Date of Death : <span id="DOD">sometext</span> </p>
        <p>Date Deposited in the Morgue : <span id="deposit_date">sometext</span> </p>
        <p>Removal Date : <span id="removal_date">sometext</span> </p>
        <p>Place of Death : <span id="POD">sometext</span> </p>
        <p>Cause of Death : <span id="cause">sometext</span> </p>

    </aside>

    <section class="modal">
        <div class="form-section">

            <div class="close-btn" title="close" id="modal">
                <i class="fas fa-x"></i>
            </div>
            <img src="" alt="" id="img-preview">
            <form action="" method="POST" enctype="multipart/form-data">
                <h3>Enter Deceased Details</h3>

                <input type="hidden" id="hidden" name="option" value="add">

                <div class="input-part">
                    <div class="input">
                        <input type="text" id="fname" name="fname" required>
                        <label for="fname">First name</label>
                    </div>

                    <div class="input">
                        <input type="text" id="lname" name="lname" required>
                        <label for="lname">Last name</label>
                    </div>
                </div>

                <div class="input-part">
                   <div class="input">
                        <input type="text" id="occupation" name="occupation" required>
                        <label for="occupation">Occupation</label>
                    </div> 

                    <fieldset>
                        <legend> Real Photo </legend>
                        <input type="file" onchange="displayImage(this)" name="picture" id="file">
                    </fieldset> 
                </div>        
                
                <div class="input-part">    
                    <fieldset>
                        <legend>Gender</legend>
                        <div>
                            <input type="radio" name="sex" value="M" id="acc1" checked/>
                            <label htmlFor="acc1">Male</label>
                        </div>
                        <div>
                            <input type="radio" name="sex" value="F" id="acc2"/>
                            <label htmlFor="acc2">Female</label>
                        </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Marital Status</legend>
                        <div>
                            <input type="radio" name="married" value="Y" id="ms1"/>
                            <label htmlFor="ms1">Married</label>
                        </div>
                        <div>
                            <input type="radio" name="married" value="N" id="acc2" checked/>
                            <label for="ms2" >Single</label>
                        </div>

                    </fieldset>   
                </div>
            
                <div class="input-part">    
                    <div class="input">
                        <input type="date" id="dob" name="DOB">
                        <label for="dob">Date of Birth</label>
                    </div> 

                    <div class="input">
                        <input type="date" id="dod" name="DOD">
                        <label for="dod">Date of Death</label>
                    </div> 
                </div> 

                <div class="input-part">    
                    <div class="input">
                        <input type="date" id="dodepo" name="dodepo">
                        <label for="dodepo">Date of Deposit</label>
                    </div> 

                    <div class="input">
                        <input type="date" id="dor" name="dor">
                        <label for="dor">Date of Removal</label>
                    </div> 
                </div> 

                <div class="input-part">
                    <div class="select-input">
                        <label for="corpse_cat">Category: </label>
                        
                        <select name="corpse_cat" id="corpse_cat">
                            <?php
                                if($categories){
                                    foreach($categories as $cat){
                            ?>
                            <option value="<?=$cat['cat_id']?>"><?=$cat['cat_name']?></option>
                            <?php
                                } }
                            ?>
                        </select>
                    </div> 

                    <div class="input">
                        <input type="text" id="place" name="place" required>
                        <label for="place">Place of Death</label>
                    </div>
                </div>
                
                <div class="textarea">
                    <textarea name="text" id="text" required></textarea>
                    <label for="text">Brief Cause of Death !!</label>
                </div>

                <input type="submit" name="add_corpse" value="Add" id="submit">
                
            </form>
        </div>
        
    </section>

    <script src="assets/JS/imgPreview.js"></script>
    <script src="assets/JS/dashboard.js"></script>

</body>
</html>