import sys
import os
import json
import pandas as pd
from sklearn.ensemble import RandomForestClassifier

def main():
    try:
        # Parse inputs - robustly handle stdin or sys.argv
        if not sys.stdin.isatty():
            input_text = sys.stdin.read()
        elif len(sys.argv) > 1:
            input_text = sys.argv[1]
        else:
            print(json.dumps({"status": "error", "message": "No input data provided"}))
            return

        if not input_text:
             print(json.dumps({"status": "error", "message": "Input data is empty"}))
             return
             
        input_data = json.loads(input_text)
        age = float(input_data.get('age', 0))
        breakdown_count = float(input_data.get('breakdown_count', 0))
        repair_cost = float(input_data.get('repair_cost', 0))
        
        # In a real scenario, downtime_hours would be predicted or input, we assume a heuristic or input
        downtime_hours = float(input_data.get('downtime_hours', age * 2)) 

        # Load Dataset
        try:
            base_dir = os.path.dirname(os.path.abspath(__file__))
            csv_path = os.path.join(base_dir, 'asset_maintenance_dataset.csv')
            df = pd.read_csv(csv_path)
        except Exception as e:
            print(json.dumps({"status": "error", "message": f"Failed to load dataset: {str(e)}"}))
            return

        # Prepare Data
        # Assume dataset has columns: age, breakdown_count, repair_cost, downtime_hours, risk_level
        features = ['age', 'breakdown_count', 'repair_cost', 'downtime_hours']
        
        # Ensure columns exist, if not create dummy for training (safety net)
        for f in features:
            if f not in df.columns:
                df[f] = 0
                
        if 'risk_level' not in df.columns:
            print(json.dumps({"status": "error", "message": "risk_level column missing in dataset"}))
            return

        X = df[features]
        y = df['risk_level']

        # Train Random Forest
        rf = RandomForestClassifier(n_estimators=100, random_state=42)
        rf.fit(X, y)

        # Predict
        X_new = pd.DataFrame([[age, breakdown_count, repair_cost, downtime_hours]], columns=features)
        prediction = rf.predict(X_new)[0]
        
        # Get Probabilities
        probs = rf.predict_proba(X_new)[0]
        classes = rf.classes_
        prob_dict = {str(c): float(p) for c, p in zip(classes, probs)}

        # Output JSON
        print(json.dumps({
            "status": "success",
            "prediction": str(prediction),
            "probabilities": prob_dict
        }))

    except Exception as e:
        print(json.dumps({"status": "error", "message": str(e)}))

if __name__ == "__main__":
    main()
