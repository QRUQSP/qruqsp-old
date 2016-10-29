This directory contains the non-database storage for stations.

The first directory in the hashing should be the first character from the station uuid.  This will split things into
16 directories a-f0-9, and if there are 10,000 stations, have approximately 625 per directory.

/qruqsp-storage/[a-f0-9]/station-uuid/qruqsp.images/[a-f0-9]/uuid-hash.extension

The uuid-hash.extension should be the items uuid from the database record of meta data. The extension should be proper for
the type of file so it's easier to find all files of a certain type on disk.
