<?php

    $req = new Request_controller();
    $req->get_requests();
    

    $categories = $_SESSION['categories'];
    $corpse = $_SESSION['corpse'] ?? [];

    if(isset($_SESSION['cats'])){
        extract($_SESSION['cats']);
    }

    $total_corpse = count($_SESSION['all_corpse']);
    $males = $females = $young = $adult = 0;

    function age($dob, $dod){
        $yob = (int)explode('-', $dob)[0];
        $yod = (int)explode('-', $dod)[0];

        return $yod-$yob;
    }

    foreach($_SESSION['all_corpse'] as $corp){
        extract($corp);

        ($gender === 'M') ? $males++ : $females++;
        (age($DOB, $DOD) <= 18) ? $young++ : $adult++;
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

        <i class="fas fa-circle-info modify" title="display page crews"></i>

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
                    <input type="hidden" name="order_by_sex" value="gender">
                    <input type="submit" name="female" value="Females">
                    <input type="submit" name="male" value="Males">

                </form>    
            </div>

            <div>
                <h3>
                    Marital Status
                </h3>
                <form action="" method="POST">
                    <input type="hidden" name="option" value="order">
                    <input type="hidden" name="order_by_married" value="married">
                    <input type="submit" name="Y" value="Married">
                    <input type="submit" name="N" value="Not Married">

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
                    <td><?=$vvip ?? NULL?></td>
                </tr> 
                <tr>
                    <td>Standard</td>
                    <td><?=$standard ?? NULL?></td>
                </tr> 
                <tr>
                    <td>VIP</td>
                    <td> <?=$vip ?? NULL?> </td>
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
                    <th>Gender</th>
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
                        <td> <?= $cor['gender']?> </td>
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
        <button id="modal_edit">
            <i class="fas fa-pen"></i>
            <span>Edit</span>
        </button>

        <i class="fas fa-x close-btn" id="aside" title="close"></i>

        <div class="img_sec">
            <img src="" alt="" class="picture">
        </div>

        <p>Deceased ID : <span class="id">sometext</span> </p>
        <p>First Name : <span class="fname">sometext</span> </p>
        <p>Last Name : <span class="lname">sometext</span> </p>
        <p>Gender : <span class="gender">sometext</span> </p>
        <p>Occupation : <span class="occupation">sometext</span> </p>
        <p>Died At : <span class="age">sometext</span> </p>
        <p>Category : <span class="cat_name">sometext</span> </p>
        <p>Price/day : <span class="price">sometext</span> frs</p>
        <p>Guardian : <span class="guardian_name">sometext</span> </p>
        <p>Guardian Email : <span class="guardian_email">sometext</span> </p>
        <p>Marital Status : <span class="marital_status">sometext</span> </p>
        <p>Date of Birth : <span class="DOB">sometext</span> </p>
        <p>Mortuary Duration so far : <span class="duration">sometext</span> days</p>
        <p>Supposed Duration : <span class="dur">sometext</span> days</p>
        <p>Total price : <span class="total_price">sometext</span>k  frs </p>
        <p>Date of Death : <span class="DOD">sometext</span> </p>
        <p>Date Deposited in the Morgue : <span class="deposit_date">sometext</span> </p>
        <p>Removal Date : <span class="removal_date">sometext</span> </p>
        <p>Place of Death : <span class="POD">sometext</span> </p>
        <p>Cause of Death : <span class="cause">sometext</span> </p>

    </aside>

    <section class="modal">
        <div class="form-section">     
            <i class="fas fa-x close-btn" id="modal" title="close"></i>

            <form action="" method="POST" enctype="multipart/form-data">
                <img src="assets/images/default.jpg" alt="" id="picture">
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

                    <div class="input">
                        <input type="text" id="occupation" name="occupation" required>
                        <label for="occupation">Occupation</label>
                    </div> 
                </div>

                <div class="input-part">
                    <fieldset>
                        <legend> Real Photo </legend>
                        <input type="file" onchange="displayImage(this)" name="picture" id="file">
                    </fieldset> 

                    <fieldset>
                        <legend>Gender</legend>
                        <div>
                            <input type="radio" name="gender" value="M" id="acc1" checked/>
                            <label htmlFor="acc1">Male</label>
                        </div>
                        <div>
                            <input type="radio" name="gender" value="F" id="acc2"/>
                            <label htmlFor="acc2">Female</label>
                        </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Marital Status</legend>
                        <div>
                            <input type="radio" name="marital_status" value="Y" id="ms1"/>
                            <label htmlFor="ms1">Married</label>
                        </div>
                        <div>
                            <input type="radio" name="marital_status" value="N" id="acc2" checked/>
                            <label for="ms2" >Single</label>
                        </div>
    
                    </fieldset>   
                </div>        
            
                <div class="input-part">    
                    <div class="input">
                        <input type="date" id="DOB" name="DOB">
                        <label for="DOB">Date of Birth</label>
                    </div> 

                    <div class="input">
                        <input type="date" id="DOD" name="DOD">
                        <label for="DOD">Date of Death</label>
                    </div> 
                    
                    <div class="input">
                        <input type="date" id="deposit_date" name="deposit_date">
                        <label for="deposite_date">Date of Deposit</label>
                    </div> 
                </div> 

                <div class="input-part">    

                    <div class="input">
                        <input type="date" id="removal_date" name="removal_date">
                        <label for="removal_date">Date of Removal</label>
                    </div> 
                    <div class="select-input">
                        <label for="corpse_cat">Category: </label>
                        
                        <select name="cat_id" id="corpse_cat">
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
                        <input type="text" id="POD" name="POD" required>
                        <label for="POD">Place of Death</label>
                    </div>
                </div> 

                <div class="input-part">
                    <div class="input">
                        <input type="text" id="guardian_name" name="guardian_name" required>
                        <label for="guardian_name">Guardian's name</label>
                    </div>

                    <div class="input">
                        <input type="email" id="guardian_email" name="guardian_email" required>
                        <label for="guardian_email">Guardian's email</label>
                    </div>    

                    <div class="input">
                        <input type="text" id="guardian_relation" name="guardian_relation" required>
                        <label for="guardian_relation">Guardian's relation</label>
                    </div>            
                </div>
                
                <div class="textarea">
                    <textarea name="cause" id="cause" required></textarea>
                    <label for="cause">Brief Cause of Death !!</label>
                </div>

                <input type="submit" name="add_corpse" value="Add" id="submit">

            </form>
        </div>
        
    </section>

    <!-- Modification for the category to go in here -->

    <article>
        <i class="fas fa-x close-btn" id="article" title="close"></i>

        <div class="table section1">
            <h3> All Categories</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Price (frs)</th>
                    <th>Tot. Corpse</th>
                </tr>
                <?php
                    foreach($categories as $cat):
                ?>
                <tr>
                    <td><?=$cat['cat_name']?></td>
                    <td><?=$cat['price']?></td>
                    <td><?=$cat['tot_corpse']?></td>
                    <td class="edit_btn">
                        <i class="fas fa-pen-to-square" title="edit"></i>
                    </td>
                </tr>
                <?php
                    endforeach;    
                ?>
            </table>
        </div>

        <div class="table section2">
            <h3>Removal Schedules</h3>
            <table>
                <tr>
                    <th>Time</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thurs</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
                
                <?php
                    // $days = ['8:00-9:30 AM', '9:30-11:00 AM', '11:00-12:30 PM', '12:30-2:00 PM', '2:00-3:30 PM', '3:30-5:00 PM'];

                    $days = ['6:00-6:05 AM', '6:05-6:10 AM', '6:10-6:15 AM', '6:15-6:20 AM', '6:20-6:25 AM', '6:25-6:30 AM'];
                    for($i = 0; $i < 6; $i++):
                ?>
    
                <tr>
                    <td><?=$days[$i]?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php 
                    endfor; 
                ?>
            </table>
        </div>

        
    </article>
    <script src="assets/JS/imgPreview.js"></script>
    <script src="assets/JS/dashboard.js"></script>

</body>
</html>