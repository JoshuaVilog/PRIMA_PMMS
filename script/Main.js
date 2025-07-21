
class Main {

    constructor(){
        this.systemLocalStorageTitle = "template";
        this.lsEmployeeList = this.systemLocalStorageTitle +"-employee-list";
        this.lsMoldList = this.systemLocalStorageTitle +"-mold-list";

    }

    GetCurrentDate(){
        let currentDate = new Date();
        let year = currentDate.getFullYear();
        let month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
        let day = currentDate.getDate().toString().padStart(2, '0');
        let formattedDate = `${year}-${month}-${day}`;

        // Outputs something like: 2024-05-29
        return formattedDate;
    }
    GetCurrentTime(){
        // Create a new Date object
        let now = new Date();
    
        // Get the current hours, minutes, and seconds
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
    
        // Format the time as HH:MM:SS
        let currentTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
        return currentTime; // Output: current time in HH:MM:SS format
    
    }

    GetPhilippinesDateTime(){
        const options = {
            timeZone: "Asia/Manila", 
            year: "numeric", 
            month: "2-digit", 
            day: "2-digit", 
            hour: "2-digit", 
            minute: "2-digit", 
            second: "2-digit",
            hour12: false
        };
    
        const formatter = new Intl.DateTimeFormat("en-US", options);
        const parts = formatter.formatToParts(new Date());
    
        // Format to YYYY-MM-DD HH:MM:SS
        const year = parts.find(p => p.type === "year").value;
        const month = parts.find(p => p.type === "month").value;
        const day = parts.find(p => p.type === "day").value;
        const hour = parts.find(p => p.type === "hour").value;
        const minute = parts.find(p => p.type === "minute").value;
        const second = parts.find(p => p.type === "second").value;
    
        return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
    }

    GetDateOnly(datetime){
        return datetime.split(' ')[0];
    }

    GetDurationMinutes(IN, OUT) {
        if (IN == null || OUT == null) {
            return 0;
        } else {
            // Parse the input strings into Date objects
            const inDate = new Date(IN);
            const outDate = new Date(OUT);
            
            // Calculate the difference in milliseconds
            const diffMs = outDate - inDate;
            
            // Convert milliseconds to minutes (with decimals)
            const diffMinutes = diffMs / 60000; // 1 minute = 60,000 ms
            
            return diffMinutes.toFixed(2);
        }
    }
    //================================================================================//

    GetEmployeeRecords(){
        let self = this;
        $.ajax({
            url: "php/controllers/Employee/EmployeeRecords.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);
                let list = response.data;

                localStorage.setItem(self.lsEmployeeList, JSON.stringify(list));
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }

    
    SetEmployeeNameByID(id){
        let list = JSON.parse(localStorage.getItem(this.lsEmployeeList));
        
        if(id == 1){
            return "SYSTEM ADMIN"
        } else {
            let result = list.find(element => element.EMPLOYEE_ID === id);

            return result ? result.EMPLOYEE_NAME: "";
        }
    }
    SetEmployeeNameByRFID(id){
        let list = JSON.parse(localStorage.getItem(this.lsEmployeeList));
        
        if(id == "ADMIN"){
            return "SYSTEM ADMIN";
        } else {
            let result = list.find(element => element.RFID === id);

            return result ? result.EMPLOYEE_NAME: "";
        }
    }

    GetMoldRecords(){
        let self = this;
        $.ajax({
            url: "php/controllers/Mold/Records.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                console.log(response);
                let list = response.data;

                localStorage.setItem(self.lsMoldList, JSON.stringify(list));
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }

}


let main = new Main();

main.GetEmployeeRecords();
main.GetMoldRecords();
