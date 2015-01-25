//Constants
var CONST_MAX_MASK_LENGTH = 11;
var CONST_MAX_MASK_COUNT = 3;
var SUPERADMIN = 1;
var CONST_SUPERADMIN_ROLE = 1;
var CONST_ACCOUNTADMIN_ROLE = 2;

//Table names
var TABLE_ACCOUNT = "account";
var TABLE_ACCOUNT_COLUMNS = "accountID, accountName, balance, mask";

var TABLE_USER = "user";
var TABLE_USER_COLUMNS = "userid, username, password, email, mobileno, accountid, roleid, active, lastupdate";

var TABLE_ROLE = "role";
var TABLE_ROLE_COLUMNS = "roleid, rolename, accountid, privilegeids, lastupdate";

var TABLE_GROUP = "smsportal.group";
var TABLE_GROUP_COLUMNS = "groupid, groupname, userid, lastupdate";

var TABLE_CONTACTLIST = "contactlist";
var TABLE_CONTACTLIST_COLUMNS = "contactlistid, name, mobileno, email, groupid, lastupdate";
