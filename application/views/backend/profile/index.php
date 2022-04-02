<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var email = document.getElementById('email').value;
        var nama = document.getElementById('nama').value;
        
        if(email === ""){
            alert("Email tidak boleh kosong");
        }else if(nama === ""){
            alert("Nama tidak boleh kosong");
        }else{
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('email', email);
            form_data.append('nama', nama);
            
            $.ajax({
                url: "<?php echo base_url(); ?>profile/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    
                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled',false);

                },error: function (response) {
                    alert(response.status);

                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled',false);
                }
            });
        }
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">PROFILE</h4>
                    <div class="forms-sample">
                        <div class="form-group">
                            <label>EMAIL</label>
                            <input id="email" name="email" type="text" class="form-control" autocomplete="off" value="<?php echo $tersimpan->email; ?>">
                        </div>
                        <div class="form-group">
                            <label>NAMA PERSONIL</label>
                            <input id="nama" name="nama" type="text" class="form-control" autocomplete="off" value="<?php echo $tersimpan->nama; ?>">
                        </div>
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>