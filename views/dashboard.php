<?php

    $courses = [];

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
            <input type="text" placeholder="Search for corpse" name="search" /> 
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
                Display Order
            </h3>
    
            <div>
                <h3>
                    Category
                </h3>
                <form action="" method="POST">
                    <input type="submit" name="vvip" value="V-VIP">
                    <input type="submit" name="vip" value="VIP">
                    <input type="submit" name="standard" value="Standard">
                </form>
            
            </div>
            <div>
                <h3>
                    Date
                </h3>
                <form action="" method="POST">
                    <input type="submit" name="asc" value="ASC">
                    <input type="submit" name="dsc" value="DSC">
                </form>
            
            </div>
        </div>

        <div class="section2">
            <h3>
                Records
            </h3>
            <table>
                <tr>
                    <th colspan="2"> Total </th>
                    <th>2</th>
                </tr>
                <tr>
                    <th rowspan="2">Sex</th>
                    <td>Males</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>Females</td>
                    <td>7</td>
                </tr> 
                <tr>
                    <th rowspan="2">Age</th>
                    <td>18 --</td>
                    <td>1 </td>
                </tr> 
                <tr>
                    <td>19 ++</td>
                    <td>3</td>
                </tr> 
                <tr>
                    <th rowspan="3">Category</th>
                    <td>V-VIP</td>
                    <td>3</td>
                </tr> 
                <tr>
                    <td>Standard</td>
                    <td>1</td>
                </tr> 
                <tr>
                    <td>VIP</td>
                    <td>2</td>
                </tr>
                
            </table>
        </div>
       
    </nav>

    <main >
        <h3>List of Deceased Individuals <span>(ALL)</span></h3>
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
                <tr>
                    <td>
                        <a href="assets/images/test.jpg" target="_blank">
                            <img src="assets/images/test.jpg" alt="">
                        </a>
                    </td>
                    <td>
                        Solange
                    </td>
                    <td>
                        2018-02-11
                    </td>
                    <td>
                        VIP
                    </td>
                    <td class="link">
                        <form action="" method="POST">        
                            <input type="submit" name="view" value="View" data-courseID="<?=$course['pd_id']?>">
                            
                            <input type="submit" name="delete" value="Delete">
                            <input type="hidden" name="hiddenID" value="<?=$course['pd_id']?>">

                        </form>
                    </td>
                </tr>
                <?php 
                    if($courses):
                    foreach($courses as $course): 
                    $price = $course['price'] / 100;
                ?>
                    <tr>
                        <td>
                            <img src="assets/images/course_images/<?= $course['pic']?>" alt="">
                        </td>
                        <td> <?= $course['pd_name']?> </td>
                        <td> <?= $course['cat_name']?></td>
                        <td class="link">
                            <form action="" method="POST">
                                
                                <input type="submit" name="view" value="View" data-courseID="<?=$course['pd_id']?>">
                                
                                <input type="submit" name="delete" value="Delete">
                                <input type="hidden" name="hiddenID" value="<?=$course['pd_id']?>">

                            </form>
                        </td>     
                    </tr>
                <?php endforeach;
                endif; ?>

            </table>
        </div>
    </main>

    <aside>
        <div class="img_sec">
            <img src="assets/images/test.jpg" alt="">
        </div>
        <p>Deceased ID : <span>sometext</span> </p>
        <p>Full Names : <span>sometext</span> </p>
        <p>Gender : <span>sometext</span> </p>
        <p>Occupation : <span>sometext</span> </p>
        <p>Life Span : <span>sometext</span> </p>
        <p>Category : <span>sometext</span> </p>
        <p>Marital Status : <span>sometext</span> </p>
        <p>Date of Birth : <span>sometext</span> </p>
        <p>Date of Death : <span>sometext</span> </p>
        <p>Cause of Death : <span>sometext</span> </p>
        <p>Place of Death : <span>sometext</span> </p>

    </aside>

    <section class="modal">
        <div class="form-section">

            <div class="close-btn" title="close">
                <i class="fas fa-x"></i>
            </div>
            <img src="" alt="" id="img-preview">
            <form action="" method="POST" enctype="multipart/form-data">
                <h3>Enter Deceased Details</h3>

                <input type="hidden" id="hidden" name="option" value="add">

                <div class="input-part">
                    <div class="input">
                        <input type="text" id="cname" name="cname" required>
                        <label for="cname">Course name</label>
                    </div>

                    <div class="input">
                    <input type="number" id="price" name="price" required>
                    <label for="price">Price(in cents)</label>
                    </div>
                </div>
            
                <div class="input-part">    
                    <div class="input">
                        <input type="number" id="number" name="chapters" required>
                        <label for="number">Number of chapters</label>
                    </div> 

                    <fieldset>
                        <legend>Course Image</legend>
                        <input type="file" onchange="displayImage(this)" name="course_img" id="file" required>
                    </fieldset> 
                    
                    <div class="input">
                        <input type="text" id="cat" name="category" required>
                        <label for="cat">Category</label>
                    </div> 

                </div>

                <div class="textarea">
                    <textarea name="text" id="text" required></textarea>
                    <label for="text">Enter description here !!</label>

                </div>

                <input type="submit" name="add" value="Add" id="submit">
                
            </form>
        </div>
        
    </section>

    <script src="assets/JS/imgPreview.js"></script>
    <script src="assets/JS/dashboard.js"></script>

</body>
</html>