sqlite3 $1 ".dump" | grep INSERT | grep -v "sqlite_sequence" > sql/dataset.sql
