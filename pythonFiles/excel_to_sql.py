from sqlalchemy import create_engine
import pandas as pd





try:
    db = "test"
    table = "asignaturas"
    path = "data_test.xlsx"

    url = "mysql://root:1234@localhost/"

    engine = create_engine(url + db , echo = False)

    df = pd.read_excel(path)
    df.to_sql(name = table , con = engine , if_exists='replace' , index_label= "id")
    print("read is ready")
except NameError:
    print(f"Error : {NameError}" )
