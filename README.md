# mCMS
mCMS is a modular-based web content management system which combines flexible output and storage systems. The core modules currently expect a MySQL Database and produces HTML based pages containing content, images and other information. The system extracts the required resource based on the path given compared to stored paths. 

mCMS is developed in object-orientated PHP 5. 

## Database

Currently the system requires a pre-existing database structure. However this is not currently included.

## Coding Standards
* Documentation is currently sparse - this is a 'known issue'. Ideally it should at minimum note any possible raised exception, the return result (if any), the method arguments (if any) and a description of the method - this is a minimum, more is better.
* All public facing methods must be input validated and raise exceptions if something is wrong. It's better to catch a bug that may happen than let it grow into something worse.
* Tab-based K&R style
* Aim to do one job and well, rather than a selection of features with limited flexibility
