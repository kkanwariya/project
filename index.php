<html><body>
  <h2>Insert a new Book</h2>
  <form name="htmlform" method="post" action="formsend.php">
  <table width="450px">
  </tr>

  <tr>
   <td valign="top">
    <label for="dob">Book Name</label>
   </td>
   <td valign="top">
    <input type="text" name="bname" maxlength="50" size="30" required>
   </td>
  </tr>


  <tr>
   <td valign="top">
    <label>Book ISBN</label>
   </td>
   <td valign="top">
    <input type="number" name="bisbn" maxlength="80" size="30" required>
   </td>
  </tr>


  <tr>
   <td valign="top">
    <label>Book Author</label>
   </td>
   <td valign="top">
    <input  type="text" name="bauthor" maxlength="30" size="30" required>
   </td>
  </tr>
  <tr>
   <td valign="top">
    <label>Book Edition</label>
   </td>
  <td valign="top">
    <input type="number" name="bedition" maxlength="30" size="30" required>
   </td>

  </tr>


  <tr>
   <td valign="top">
    <label>No of Books</label>
   </td>
  <td valign="top">
    <input  type="number" name="nbooks" maxlength="30" size="30">
   </td>

  </tr>

  <tr>
   <td colspan="2" style="text-align:center">
    <input type="submit" value="Submit">
   </td>
  </tr>

  </table>
  </form>







  <h2>Issue a Book</h2>
  <form name="htmlform" method="post" action="update.php">
  <table width="450px">
  </tr>
  <td valign="top">
   <input  type="hidden" name="id" maxlength="30" size="30" value="issue">
  </td>
  <tr>
   <td valign="top">
    <label>Book Id</label>
   </td>
   <td valign="top">
    <input  type="text" name="bid" maxlength="50" size="30">
   </td>
  </tr>
  <tr>
   <td valign="top">
    <label>Customer id</label>
   </td>
   <td valign="top">
    <input type="text" name="cid" maxlength="50" size="30">
   </td>
  </tr>

  </tr>
  <tr>
   <td colspan="2" style="text-align:center">
    <input type="submit" value="Submit">
   </td>
  </tr>
  </table>
  </form>


<h2>Account</h2>
  <form name="htmlform" method="post" action="update.php">
  <table width="450px">
  </tr>
  <td valign="top">
   <input  type="hidden" name="id" maxlength="30" size="30" value="3">
  </td>
  <tr>
   <td valign="top">
    <label for="name">Bank name</label>
   </td>
   <td valign="top">
    <input  type="text" name="bname" maxlength="50" size="30">
   </td>
  </tr>
  <tr>
   <td valign="top">
    <label for="dob">Balance</label>
   </td>
   <td valign="top">
    <input  type="text" name="balance" maxlength="50" size="30">
   </td>
  </tr>

  </tr>
  <tr>
   <td colspan="2" style="text-align:center">
    <input type="submit" value="Submit">
   </td>
  </tr>
  </table>
  </form>

<h2>Loan</h2>
  <form name="htmlform" method="post" action="update.php">
  <table width="450px">
  </tr>
  <td valign="top">
   <input  type="hidden" name="id" maxlength="30" size="30" value="4">
  </td>
  <tr>
   <td valign="top">
    <label for="name">Bank name</label>
   </td>
   <td valign="top">
    <input  type="text" name="bname" maxlength="50" size="30">
   </td>
  </tr>
  <tr>
   <td valign="top">
    <label for="dob">Amount</label>
   </td>
   <td valign="top">
    <input  type="text" name="amount" maxlength="50" size="30">
   </td>
  </tr>

  </tr>
  <tr>
   <td colspan="2" style="text-align:center">
    <input type="submit" value="Submit">
   </td>
  </tr>
  </table>
  </form>


<h2>depositor</h2>
  <form name="htmlform" method="post" action="update.php">
  <table width="450px">
  </tr>
  <td valign="top">
   <input  type="hidden" name="id" maxlength="30" size="30" value="5">
  </td>
  <tr>
   <td valign="top">
    <label for="name">Cid</label>
   </td>
   <td valign="top">
    <input  type="text" name="bname" maxlength="50" size="30">
   </td>
  </tr>
  <tr>
   <td valign="top">
    <label for="dob">Account Number</label>
   </td>
   <td valign="top">
    <input  type="text" name="accno" maxlength="50" size="30">
   </td>
  </tr>

  </tr>
  <tr>
   <td colspan="2" style="text-align:center">
    <input type="submit" value="Submit">
   </td>
  </tr>
  </table>
  </form>

<h2>Borrower</h2>
  <form name="htmlform" method="post" action="update.php">
  <table width="450px">
  </tr>
  <td valign="top">
   <input  type="hidden" name="id" maxlength="30" size="30" value="6">
  </td>
  <tr>
   <td valign="top">
    <label for="name">Cid</label>
   </td>
   <td valign="top">
    <input  type="text" name="bname" maxlength="50" size="30">
   </td>
  </tr>
  <tr>
   <td valign="top">
    <label for="dob">Loan Number</label>
   </td>
   <td valign="top">
    <input  type="text" name="loancno" maxlength="50" size="30">
   </td>
  </tr>

  </tr>
  <tr>
   <td colspan="2" style="text-align:center">
    <input type="submit" value="Submit">
   </td>
  </tr>
  </table>
  </form>


</body>
</html>
