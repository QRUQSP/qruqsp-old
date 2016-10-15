QRUQSP Modules
==============

The main qruqsp repo is a super repo which consists mostly of a container for storing the other submodules required.

Module List
-----------

### core
This module is required for every QRUQSP project. This module contains the functions to access and modify the information 
in the database, control who has access to the information and a list of stations in the database.

### images
All images used in any other module should be stored in this module and referenced. This module manages the storage
of images and the processing to reduce size for websites etc.

### sysadmin
A collection of tools to manaage the system. This may not be required on all installs and so it is a separate module from core.

### systemdocs
This module contains code parsers to import and understand the code to the database. Once the code is in the database
the list of tables, documentation and other information can be accessed.

### bugs
This module tracks the bugs and questions submitted by users of the system. Bugs are typically submitted when something goes wrong
and the UI presents the user with the option of submitting a bug.


Creating a new submodule
------------------------
The new submodule must first be created on github.com under the QRUQSP project. The module should be initialized with a README so there 
are no warnings when checking out an empty module.

Once the submodule has been created, it needs to be added to the super repo. The submodule must not be added as the git@github.com 
user because then anybody who checks out the super repo needs write permissions to access the submodule. Including the submodule
initially as https://github.com/ will provide read only access to anybody who wants it. After the permissions to push changes
to github.com is added using git remote add push.

```
cd ~/projects/qruqsp/qruqsp.local
# hey you with the keyboard replace "<submodule_name>" with the submodule you need
git submodule add https://github.com/qruqsp/<submodule_name>.git site/qruqsp-mods/<submodule_name>
cd site/qruqsp-mods/<submodule_name>
git checkout master
git remote add push git@github.com:qruqsp/<submodule_name>.git
```

Initialize the new submodule.
```
rm README.md
../../../dev-tools/mod_init.php qruqsp <submodule_name> <submodule_title> 1
```

Create the database files


Create the objects file
