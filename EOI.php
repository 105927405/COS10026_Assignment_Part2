<?php 
    $selectedJob = $_GET['job'] ?? '';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'settings.php';
    
    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

<!DOCTYPE html>
<html lang = "en">
<?php include 'header.inc'; ?>
    
<form method="post" action="ProcessEOI.php">

<!--personal infomation-->
<body>
<fieldset>
    <div><label for="F_name">First Name</label>
        <input type="text" name="F_name" pattern="[A-Za-z]+" id="F_name" maxlength="20" size="10" placeholder="First Name" required/>

        <label for="L_name">Last Name</label>
        <input type="text" name="L_name" pattern="[A-Za-z]+" id="L_name" maxlength="20" size="10" placeholder="Last Name" required/>
        <br>

        <label for="DOB">Date of Birth</label>
        <input type="date" name="DOB" id="DOB" required/>
    </div>
</fieldset>

<fieldset>
    <p>
        <label for="Email" class="Email"> Email </label>
        <input type="email" name="Email" id="Email" placeholder="email" required/>
    </p>
</fieldset>

<fieldset>
    <p>
        <label for="Phone_NUM">Phone No.</label>
        <input type="tel" name="Phone_NUM" id="Phone_NUM" 
        placeholder="Enter Phone Number" pattern="[0-9]{10}" maxlength="10" required/>
    </p>
</fieldset>

<fieldset>
    <p>
        <label for="Gender">Gender</label>
        <br>
        <input type="radio" name="Gender" id="male" value="male" required/>
        <label for="male">Male</label>
        
        <input type="radio" name="Gender" id="female" value="female"/>
        <label for="female">Female</label>
        
        <input type="radio" name="Gender" id="other" value="other"/>
        <label for="other">Other</label>
         
    </p>
</fieldset>

<!--Job selection-->

<fieldset>
    <div>
        <label for="Job">Job</label>
        <select name="Job" id="Job" required>
            
        <option value="" disabled <?= empty($selectedJob) ? 'selected' :''?>>
            Please select a position</option>
        
            
        <?php
        $sql = "SELECT REF_NUM, Job_Name FROM Jobs";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0){
            while ($row = $result->fetch_assoc())
                {
                    $selected = ($selectedJobs ==$row['REF_NUM'])
                        ? 'selected'
                        : '';
                    ?>

                    <option
                        value="<?= htmlspecialchars($row['REF_NUM']) ?>"
                        <?= $selected ?>>
                        <?= htmlspecialchars($row['Job_Name']) ?>
                    </option>
                    <?php
                }
        }
        else
        {
            ?>
            <option value="" disabled>
                No jobs available
            </option>
            <?php
        }
        ?>    
        </select>
    </div>
</fieldset>

<!-- 
<fieldset>
    <div>
        <label for="job">Job</label>
        <select name="job" id="job" required>
            <option value="" disabled <?= empty($selectedJob) ? 'selected' :''?>>
            Please select a position</option>
            <option value="000A1" <?= $selectedJob == '000A1' ? 'selected' :''?>>
            Frontend web developers</option>
            <option value="000A2" <?= $selectedJob == '000A2' ? 'selected' :''?>>
                Backend web developers</option>
            <option value="000A3" <?= $selectedJob == '000A3' ? 'selected' :''?>>
                UI/UX Developers & Designers</option>
            <option value="000A4" <?= $selectedJob == '000A4' ? 'selected' :''?>>
                Graphic designers</option>
            <option value="000A5" <?= $selectedJob == '000A5' ? 'selected' :''?>>
                Technical support (Call centre worker)</option>
        </select>
    </div>
</fieldset>
-->

<!--Work Availabibity-->
<fieldset>
    <p>
        Please select days you are available and what times would work best.
    </p>

    <label for="monday">Monday</label>
    <input type="checkbox" id="monday" name="monday"/>
    <input type="time" id="montimein" name="montimein"/>
    <label for="monday" class="till"> till </label>
    <input type="time" id="montimeout" name="montimeout"/>
    <br>

    <label for="tuesday">Tuesday</label>
    <input type="checkbox" id="tuesday" name="tuesday"/>
    <input type="time" id="tuetimein" name="tuetimein"/>
    <label for="tuesday" class="till"> till </label>
    <input type="time" id="tuetimeout" name="tuetimeout"/>
    <br>

    <label for="wednesday">Wednesday</label>
    <input type="checkbox" id="wednesday" name="wednesday"/>
    <input type="time" id="wedtimein" name="wedtimein"/>
    <label for="wednesday" class="till"> till </label>
    <input type="time" id="wedtimeout" name="wedtimeout"/>
    <br>

    <label for="thursday">Thursday</label>
    <input type="checkbox" id="thursday" name="thursday"/>
    <input type="time" id="thurtimein" name="thurtimein"/>
    <label for="thursday" class="till"> till </label>
    <input type="time" id="thurtimeout" name="thurtimeout"/>
    <br>

    <label for="friday">Friday</label>
    <input type="checkbox" id="friday" name="friday"/>
    <input type="time" id="fritimein" name="fritimein"/>
    <label for="friday" class="till"> till </label>
    <input type="time" id="fritimeout" name="fritimeout"/>
    <br>

    <label for="saturday">Saturday</label>
    <input type="checkbox" id="saturday" name="saturday"/>
    <input type="time" id="sattimein" name="sattimein"/>
    <label for="saturday" class="till"> till </label>
    <input type="time" id="sattimeout" name="sattimeout"/>
    <br>

    <label for="sunday">Sunday</label>
    <input type="checkbox" id="sunday" name="sunday"/>
    <input type="time" id="suntimein" name="suntimein"/>
    <label for="sunday" class="till"> till </label>
    <input type="time" id="suntimeout" name="suntimeout"/>
    
</fieldset>


<!-- infomation on applicants home address-->
<fieldset>
    <p>
        <label for="Address">Address</label>
        <input type="text" name="Address" id="Address" placeholder="Street address" maxlength="40" required/>
            <br>
        <label for="Suburb">Suburb/Town</label>
        <input type="text" name="Suburb" id="Suburb" placeholder="suburb/town" maxlength="40" required/>

        <label for="State">State</label>
        <select name="State" id="State" required>
            <option value="" disabled selected>Please select your State</option>
            <option value="1">VIC</option>
            <option value="2">NSW</option>
            <option value="3">QLD</option>
            <option value="4">NT</option>
            <option value="5">WA</option>
            <option value="6">SA</option>
            <option value="7">TAS</option>
            <option value="8">ACT</option>
        </select>

        <label for="Post_Code">Post Code</label>
        <input type="text" name="Post_Code" id="Post_Code" placeholder="PostCode" pattern="[0-9]{4}" maxlength="4" required/>
    </p>
</fieldset>

<!-- applicant selects from preselected skills-->
<fieldset>
    <p>
        Please select the skills you have.
    </p>
    <p>
        <label for="communacation">
            Communacation
            <input type="checkbox" id="communacation" name="communacation"/>
        </label>
        

        <label for="teamwork">
            Team Work
            <input type="checkbox" id="teamwork" required name="teamwork"/>
        </label>
        

        <label for="time">
            Time Mannagement
            <input type="checkbox" id="time" name="time"/>
        </label>
        

        <label for="cs">
            Customer Service
            <input type="checkbox" id="cs" name="cs"/>
        </label>
        
        <label for="BPS">
            Basic Programming Skills
            <input type="checkbox" id="BPS" name="BPS"/>
        </label>

        <label for="APS">
            Advanced Programming Skills
            <input type="checkbox" id="APS" name="APS" />
        </label>

        <label for="BDS">
            Basic Design Skills
            <input type="checkbox" id="BDS" name="BDS" />
        </label>

        <label for="ADS">
            Advanced Design Skills
            <input type="checkbox" id="ADS" name="ADS" />
        </label>

        <label for="BTS">
            Basic Technical Skills
            <input type="checkbox" id="BTS" name="BTS"/>
        </label>

        <label for="ATS">
            Advanced Technical Skills
            <input type="checkbox" id="ATS" name="ATS"/>
        </label>

        <label for="Js">
            JIRA Skills
            <input type="checkbox" id="Js" name="Js"/>
        </label>

    </p>
</fieldset>


<fieldset>
    <label for="Extra_Skills">Extra Skills</label>
        <br>
        <textarea required id="Extra_Skills" name="Extra_Skills" rows="7" cols="40" placeholder="Write any other skills you have..."></textarea>
</fieldset>

<fieldset>
    <p>
        <label for="Cover_Letter">Upload Cover Letter</label>
        <label class="UploadButton">
            Choose File
        <input type="file" name="Cover_Letter" id="Cover_Letter"/>
        </label>
    </p>
    
    <p>
        <label for="Write_Letter">Or type your cover letter</label>
        <br>
        <textarea id="Write_Letter" name="Write_Letter" rows="4" cols="40" placeholder="Type you cover letter here..."></textarea>
    </p>
</fieldset>

<fieldset>
    <p>
        <label for="Resume">Upload Resume</label>
        <label class="UploadButton">
            Choose File
            <input type="file" name="Resume" id="Resume" required/>
        </label>
    </p>
</fieldset>


<button type="submit" name="submit">Apply Now</button>
<button type="reset" name="reset">Reset form</button>
</form>


<?php include 'footer.inc'; ?>
</body>
</html>