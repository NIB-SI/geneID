# geneID
geneID app


# Comment section
## Un
```
PGSC0003DMC402000072
PGSC0003DMC402000097
PGSC0003DMC402000271
PGSC0003DMC402000180
```

# Hints section
## subset fasta
```
for f in *fasta; do
    echo $f
    xargs faidx -d ' ' $f \
    < 5cv_weak-components_extract-IDs.txt > \
    ./out/subset_$f 2> ./err/subset_$f.error;
done;
```
