<div class="container">
    <h2>You are in the View: application/view/customer/edit.php (everything in this box comes from that file)</h2>
    <!-- add customer form -->
    <div>
        <h3>Edit a customer</h3>
        <form action="<?php echo URL; ?>customers/updatecustomer" method="POST">
            <label>firstname</label>
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($customer->firstname, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>lastname</label>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($customer->lastname, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>email</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($customer->email, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>password</label>
            <input type="text" name="password" value="<?php echo htmlspecialchars($customer->password, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($customer->phone, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>street</label>
            <input type="text" name="street" value="<?php echo htmlspecialchars($customer->street, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>city</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($customer->city, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>zipcode</label>
            <input type="text" name="zipcode" value="<?php echo htmlspecialchars($customer->zipcode, ENT_QUOTES, 'UTF-8'); ?>" required />
            <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="submit" name="submit_update_customer" value="Update" />
        </form>
    </div>
</div>


