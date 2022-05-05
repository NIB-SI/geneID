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

## 2nd step translation
```
PGSC0003DMG400031320
PGSC0003DMG402021564
PGSC0003DMG401021549
PGSC0003DMG400019386
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

## tab to fasta
<https://fairdomhub.org/data_files/3420>

## MS SQL MySQL migrations 

<https://www.mysql.com/products/workbench/migrate/>

<https://dev.mysql.com/doc/workbench/en/wb-migration-install.html>



## FLASK

<https://blog.appseed.us/flask-react-full-stack-seed-projects/>

<https://dev.to/dev_elie/connecting-a-react-frontend-to-a-flask-backend-h1o>

<https://flask.palletsprojects.com/en/2.0.x/>

<https://dev.to/gajesh/the-complete-flask-beginner-tutorial-124i>

# other tools
<https://igraph.org/>

<https://cytoscape.org/>

<https://github.com/neo4j/neo4j>

# FASTA files
<https://fairdomhub.org/assays/1268?graph_view=tree>

<https://fairdomhub.org/data_files/3424>

<https://fairdomhub.org/data_files/3415>

