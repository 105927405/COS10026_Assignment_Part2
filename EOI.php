<!DOCTYPE html>
<html lang = "en">
<?php include 'header.inc'; ?>
    

 

<form method="post" action="https://mercury.swin.edu.au/it000000/formtest.php">

<!--personal infomation-->

<fieldset>
    <div><label for="first_name">First Name</label>
        <input type="text" name="first_name" pattern="[A-Za-z]+" id="first_name" maxlength="20" size="10" placeholder="First Name" required/>

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" pattern="[A-Za-z]+" id="last_name" maxlength="20" size="10" placeholder="Last Name" required/>
        <br>

        <label for="DOB">Date of Birth</label>
        <input type="date" name="DOB" id="DOB" required/>
    </div>
</fieldset>

<fieldset>
    <p>
        <label for="email" class="email"> Email </label>
        <input type="email" name="email" id="email" placeholder="email" required/>
    </p>
</fieldset>

<fieldset>
    <p>
        <label for="phone">Phone No.</label>
        <input type="tel" name="phone" id="phone" 
        placeholder="Enter Phone Number" maxlength="11" required/>
    </p>
</fieldset>

<fieldset>
    <p>
        <label for="gender">Gender</label>
        <br>
        <input type="radio" name="gender" id="male" value="male" required/>
        <label for="male">Male</label>
        
        <input type="radio" name="gender" id="female" value="female"/>
        <label for="female">Female</label>
        
        <input type="radio" name="gender" id="other" value="other"/>
        <label for="other">Other</label>
         
    </p>
</fieldset>

<!--Job selection-->

<fieldset>
    <div>
        <label for="job">Job</label>
        <select name="job" id="job" required>
            <option value="" disabled selected>Please select a position</option>
            <option value="000A1">Frontend web developers</option>
            <option value="000A2">Backend web developers</option>
            <option value="000A3">UI/UX Developers & Designers</option>
            <option value="000A4">Graphic designers</option>
            <option value="000A5">Technical support (Call centre worker)</option>
        </select>
    </div>
</fieldset>

<!--Work Availabibity-->


<fieldset>
    <p>
        Please select days you are available and what times would work best.
    </p>

    <label for="monday">Monday</label>
    <input type="checkbox" id="monday" name="monday"/>
    <input type="time" id="monday-start"/>
    <label for="monday" class="till"> till </label>
    <input type="time" id="monday-end"/>
    <br>

    <label for="tuesday">Tuesday</label>
    <input type="checkbox" id="tuesday" name="tuesday"/>
    <input type="time" id="tuesday-start"/>
    <label for="tuesday" class="till"> till </label>
    <input type="time" id="tuesday-end"/>
    <br>

    <label for="wednesday">Wednesday</label>
    <input type="checkbox" id="wednesday" name="wednesday"/>
    <input type="time" id="wednesday-start"/>
    <label for="wednesday" class="till"> till </label>
    <input type="time" id="wednesday-end"/>
    <br>

    <label for="thursday">Thursday</label>
    <input type="checkbox" id="thursday" name="thursday"/>
    <input type="time" id="thursday-start"/>
    <label for="thursday" class="till"> till </label>
    <input type="time" id="thursday-end"/>
    <br>

    <label for="friday">Friday</label>
    <input type="checkbox" id="friday" name="friday"/>
    <input type="time" id="friday-start"/>
    <label for="friday" class="till"> till </label>
    <input type="time" id="friday-end"/>
    <br>

    <label for="saturday">Saturday</label>
    <input type="checkbox" id="saturday" name="saturday"/>
    <input type="time" id="saturday-start"/>
    <label for="saturday" class="till"> till </label>
    <input type="time" id="saturday-end"/>
    <br>

    <label for="sunday">Sunday</label>
    <input type="checkbox" id="sunday" name="sunday"/>
    <input type="time" id="sunday-start"/>
    <label for="sunday" class="till"> till </label>
    <input type="time" id="sunday-end"/>
    
</fieldset>


<!-- infomation on applicants home address-->
<fieldset>
    <p>
        <label for="address">Address</label>
        <input type="text" name="address" id="address" placeholder="Street address" maxlength="40" required/>
            <br>
        <label for="suburbtown">Suburb/Town</label>
        <input type="text" name="suburbtown" id="suburbtown" placeholder="suburb/town" maxlength="40" required/>

        <label for="state">State</label>
        <select name="state" id="state" required>
            <option value="" disabled selected>Please select your state</option>
            <option value="1">VIC</option>
            <option value="2">NSW</option>
            <option value="3">QLD</option>
            <option value="4">NT</option>
            <option value="5">WA</option>
            <option value="6">SA</option>
            <option value="7">TAS</option>
            <option value="8">ACT</option>
        </select>

        <label for="pstcode">Post Code</label>
        <input type="text" name="pstcode" id="pstcode" placeholder="PostCode" maxlength="4" required/>
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

        <label for="BTS">
            Basic Technical Skills
            <input type="checkbox" id="BTS" name="BTS"/>
        </label>

        <label for="Js">
            JIRA Skills
            <input type="checkbox" id="Js" name="Js"/>
        </label>

    </p>
</fieldset>


<fieldset>
    <label for="skills2">Extra Skills</label>
        <br>
        <textarea required id="skills2" name="skills2" rows="7" cols="40" placeholder="Write any other skills you have..."></textarea>
</fieldset>

<fieldset>
    <p>
        <label for="cl_upload">Upload Cover Letter</label>
        <label class="UploadButton">
            Choose File
        <input type="file" name="cl_upload" id="cl_upload"/>
        </label>
    </p>
    
    <p>
        <label for="wright_cl">Or type your cover letter</label>
        <br>
        <textarea id="wright_cl" name="wright_cl" rows="4" cols="40" placeholder="Type you cover letter here..."></textarea>
    </p>
</fieldset>

<fieldset>
    <p>
        <label for="res_upload">Upload Resume</label>
        <label class="UploadButton">
            Choose File
            <input type="file" name="res_upload" id="res_upload" required/>
        </label>
    </p>
</fieldset>


<button type="submit" name="submit">Apply Now</button>
<button type="reset" name="reset">Reset form</button>
</form>


<?php include 'footer.inc'; ?>
</body>
</html>