# HACKING

`fingerprint.php` does all the work. Just run it. versions.txt is generated from a list of all usable tags on the electron repo. 

This includes all releases that were not:

1. nightly releases
2. beta releases
3. older than 0.24.0 (electron was called atom-shell before that)

All generated hashes are kept in `hashes/`. The generated lookup table is saved at lookup.json