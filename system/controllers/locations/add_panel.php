<?include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>

<div class="box">
    <div >
        <form action="<?=PROJECT_URL?>/system/controllers/locations/add_part.php" method="post" >
        </form>
    </div>
    <div >
        <form action="<?=PROJECT_URL?>/system/controllers/locations/add_part.php" method="post" >
            <div class="flex-box flex-vertical-bottom">
                <div>
                    <input type="text" required name="title" placeholder="название нас пункта" />
                </div>
                <div>
                    <div>
                        тип нас пункта(селект)
                    </div>
                    <div>
                        <select style="max-width: 150px;" required name="town_type">
                            <?
                            $sql = $pdo->prepare("SELECT * FROM l_towns_types");
                            $sql->execute();
                            while($sql_src =$sql->fetch(PDO::FETCH_LAZY)){
                                echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="datalist-company-block">
                        <div class="datalist-field"  style="position: relative;">
                            <span></span>
                            <input data-table="l_districts" class="datalist-input" data-async="1" placeholder="район нас пункта"  type="text" value="" p />
                            <input type="hidden" value="" required name="town_district"/>
                            <div class="field-list-variants box-small" style="position: absolute; display: none; background: white; z-index: 999; height: 150px; width: 100%;  overflow-y: scroll; border: 1px solid grey" >

                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="table" value="l_towns" />
                </div>
                <div>
                    <button class="btn-async">+</button>
                </div>
            </div>
        </form>
    </div>
    <div>
        <form action="<?=PROJECT_URL?>/system/controllers/locations/add_part.php" method="post"  class="flex-box">
            <div>
                <input required type="text" name="title" placeholder="Регион" />
            </div>
            <div>
                <input type="hidden" name="table" value="l_regions" />
            </div>
            <button class="btn-async">+</button>
        </form>
    </div>
    <div>
        <form action="<?=PROJECT_URL?>/system/controllers/locations/add_part.php" method="post"  class="flex-box">
            <div>
                <input type="text" name="title" placeholder="Район" />
            </div>
            <div>
                <input type="hidden" name="table" value="l_districts" />
            </div>
            <button class="btn-async">+</button>
        </form>
    </div>
    <div>
        <form action="<?=PROJECT_URL?>/system/controllers/locations/add_part.php" method="post"  class="flex-box">
            <div>
                <input required type="text" name="title" placeholder="Район бывший" />
            </div>
            <div>
                <input type="hidden" name="table" value="l_districts_former" />
            </div>
            <button class="btn-async">+</button>
        </form>
    </div>
</div>



