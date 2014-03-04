using System;
using System.Collections.Generic;
using System.Text;
using Excel = Microsoft.Office.Interop.Excel;
using System.Reflection;
using System.IO;
using System.Drawing;

namespace ExcelModule
{
    public class Workbook
    {
        public Excel.Workbook openWorkbookNoParams(String workBookPath){

            Microsoft.Office.Interop.Excel.Application excelApplication = new Microsoft.Office.Interop.Excel.ApplicationClass();
            excelApplication.Visible = true;
            excelApplication = new Microsoft.Office.Interop.Excel.ApplicationClass();
            Microsoft.Office.Interop.Excel.Workbook excelWorkbook;
            excelWorkbook = excelApplication.Workbooks.Open(workBookPath, Missing.Value, Missing.Value, Missing.Value, Missing.Value, Missing.Value,
                Missing.Value, Missing.Value, Missing.Value,
                Missing.Value, Missing.Value, Missing.Value,
                Missing.Value, Missing.Value, Missing.Value);
            return excelWorkbook;
        }

        public Excel.Workbook createWorkbook(String workBookName)
        {
            Microsoft.Office.Interop.Excel.Application excelApplication;
            Microsoft.Office.Interop.Excel.Workbook excelWorkbook;
            excelApplication = new Microsoft.Office.Interop.Excel.ApplicationClass();

            excelWorkbook = excelApplication.Workbooks.Add(Missing.Value);
            FileInfo file = new FileInfo(workBookName);
            excelWorkbook.SaveAs(file, Microsoft.Office.Interop.Excel.XlFileFormat.xlWorkbookNormal, Missing.Value, Missing.Value, false, false, Microsoft.Office.Interop.Excel.XlSaveAsAccessMode.xlNoChange, Missing.Value, Missing.Value, Missing.Value, Missing.Value, Missing.Value);
            return excelWorkbook;
          
        }

        public Excel.Worksheet setActiveWorksheet(Excel.Workbook excelWb)
        {
            Microsoft.Office.Interop.Excel.Worksheet excelWorksheet;
            excelWorksheet = (Excel.Worksheet)excelWb.ActiveSheet;
//            excelWorksheet.get_Range("j1", "j50").PageBreak = (int)Excel.XlPageBreak.xlPageBreakAutomatic;    
            excelWorksheet.PageSetup.RightMargin = 0;
            return excelWorksheet;
        }

        public Excel.Worksheet selectExistingWorksheet(String workSheetName, Excel.Workbook excelWorkbook)
        {
            Microsoft.Office.Interop.Excel.Worksheet excelWorksheet;

            excelWorksheet = (Excel.Worksheet)excelWorkbook.Worksheets[workSheetName];
            if (excelWorksheet == null)
            {
                excelWorksheet = (Microsoft.Office.Interop.Excel.Worksheet)createWorksheet(workSheetName, excelWorkbook);
            }
//            excelWorksheet.get_Range("j1", "j50").PageBreak = (int)Excel.XlPageBreak.xlPageBreakAutomatic;    
            excelWorksheet.PageSetup.RightMargin = 0;

            return excelWorksheet;
        }

        public Excel.Worksheet createWorksheet(String workSheetName, Excel.Workbook excelWorkbook)
        {
            Microsoft.Office.Interop.Excel.Worksheet excelWorksheet;
            excelWorksheet = (Excel.Worksheet)excelWorkbook.Worksheets.Add(Missing.Value, Missing.Value, Missing.Value, Missing.Value);
            excelWorksheet.Name = workSheetName;
//            excelWorksheet.get_Range("j1", "j50").PageBreak = (int)Excel.XlPageBreak.xlPageBreakAutomatic;    
            excelWorksheet.PageSetup.RightMargin = 0;

            return excelWorksheet;

        }

        //For editing and making content
        public void insertImage(String imageName, String rangeA, String rangeB, String merged, Excel.Worksheet excellWorksheet) 
        {
            Image imageFile = Image.FromFile(imageName);
            System.Windows.Forms.Clipboard.SetDataObject(imageFile, true);
            Microsoft.Office.Interop.Excel.Range excellRange;

            if (rangeB == "")
            {
                excellWorksheet.get_Range(rangeA, Missing.Value).set_Item(1, 1, imageFile);
                excellRange = excellWorksheet.get_Range(rangeA, Missing.Value);
                
            }

            else
            {
                if (merged == "true")
                {
                    excellWorksheet.get_Range(rangeA, rangeB).MergeCells = merged;
                }
                excellWorksheet.get_Range(rangeA, rangeB).set_Item(1, 1, imageFile);
                excellRange = excellWorksheet.get_Range(rangeA, rangeB);

            }
            excellWorksheet.Paste(excellRange, imageName);


        }

        public void boldFaceContent(String rangeA, String rangeB, Excel.Worksheet excellWorksheet)
        {
            if (rangeB == "")
            {
                excellWorksheet.get_Range(rangeA, Missing.Value).Font.Bold = true;
            }

            else
            {
                excellWorksheet.get_Range(rangeA, rangeB).Font.Bold = true;
            }

        }

        public String fileExists(String filename)
        {
            String fileDoesExist = "true";
            if (File.Exists(filename))
            {
                fileDoesExist = "true";

            }
            else
            {
                fileDoesExist = "false";


            }
            return fileDoesExist;
        }

        public void deleteFile(String filename)
        {
            File.Delete(filename);
        }

        public void tableContent(String rangeA, String rangeB, Excel.Worksheet excellWorksheet)
        {
            if (rangeB == "")
            {
                Microsoft.Office.Interop.Excel.Range excellRange = excellWorksheet.get_Range(rangeA, Missing.Value);
                excellRange.Borders.LineStyle = Microsoft.Office.Interop.Excel.XlLineStyle.xlContinuous;
                excellRange.Borders[Microsoft.Office.Interop.Excel.XlBordersIndex.xlEdgeBottom].Color = Color.Black.ToArgb();
                excellRange.Borders[Microsoft.Office.Interop.Excel.XlBordersIndex.xlEdgeTop].Color = Color.Black.ToArgb();
                excellRange.Borders[Microsoft.Office.Interop.Excel.XlBordersIndex.xlEdgeLeft].Color = Color.Black.ToArgb();
                excellRange.Borders[Microsoft.Office.Interop.Excel.XlBordersIndex.xlEdgeRight].Color = Color.Black.ToArgb();
            }

            else
            {
                Microsoft.Office.Interop.Excel.Range excellRange = excellWorksheet.get_Range(rangeA, rangeB);
                excellRange.Borders.LineStyle = Microsoft.Office.Interop.Excel.XlLineStyle.xlContinuous;
                excellRange.Borders[Microsoft.Office.Interop.Excel.XlBordersIndex.xlEdgeBottom].Color = Color.Black.ToArgb();
                excellRange.Borders[Microsoft.Office.Interop.Excel.XlBordersIndex.xlEdgeTop].Color = Color.Black.ToArgb();
                excellRange.Borders[Microsoft.Office.Interop.Excel.XlBordersIndex.xlEdgeLeft].Color = Color.Black.ToArgb();
                excellRange.Borders[Microsoft.Office.Interop.Excel.XlBordersIndex.xlEdgeRight].Color = Color.Black.ToArgb();

            }
        }





        public void setWorksheetContent(String content, String rangeA, String rangeB, String merged, Excel.Worksheet excellWorksheet)
        {
            if (rangeB == "")
            {
                excellWorksheet.get_Range(rangeA, Missing.Value).Formula = content;
                excellWorksheet.get_Range(rangeA, rangeB).WrapText = true;
            }

            else
            {
                if (merged == "true")
                {
                    excellWorksheet.get_Range(rangeA, rangeB).MergeCells = merged;
                    excellWorksheet.get_Range(rangeA, rangeB).HorizontalAlignment = Excel.XlHAlign.xlHAlignCenter;
                    excellWorksheet.get_Range(rangeA, rangeB).VerticalAlignment = Excel.XlVAlign.xlVAlignCenter;
                    excellWorksheet.get_Range(rangeA, rangeB).WrapText = true;
                }
                    excellWorksheet.get_Range(rangeA, rangeB).Formula = content;
            }
            
            
        }

        public String getWorksheetContent(String rangeA, String rangeB, Excel.Worksheet workSheet)
        {
            String content = "";
            if (rangeB == "")
            {
                content = workSheet.get_Range(rangeA, Missing.Value).Formula.ToString();
            }
            else
            {
                content = workSheet.get_Range(rangeA, rangeB).Formula.ToString();

            }

            return content;
        }

        public void setRangeSize(String height, String width, Excel.Worksheet workSheet, String rangeA, String rangeB)
        {
            if (rangeB == "")
            {
                workSheet.get_Range(rangeA, Missing.Value).RowHeight = Convert.ToDouble(height);
                workSheet.get_Range(rangeA, Missing.Value).ColumnWidth = Convert.ToDouble(width);

            }
            else
            {
                workSheet.get_Range(rangeA, rangeB).RowHeight = Convert.ToDouble(height);
                workSheet.get_Range(rangeA, rangeB).ColumnWidth = Convert.ToDouble(width);
            }
        }
        
        public void saveWorkbook(Excel.Workbook excell)
        {
            excell.Save();
            excell.Close(false, false, Missing.Value);
        }

        public void saveWorkBookCopy(String filename,Excel.Workbook excell)
        {
            FileInfo file = new FileInfo(filename);
            excell.SaveCopyAs(file);
            excell.Close(false, false, Missing.Value);

        }

        public void setMinorHeading(String rangeA, String rangeB, Excel.Worksheet excellWorksheet, String merged)
        {
            excellWorksheet.get_Range(rangeA, rangeB).Font.Size = 12;
            excellWorksheet.get_Range(rangeA, rangeB).Font.Bold = true;
            excellWorksheet.get_Range(rangeA, rangeB).HorizontalAlignment = Excel.XlHAlign.xlHAlignCenter;
            excellWorksheet.get_Range(rangeA, rangeB).VerticalAlignment = Excel.XlVAlign.xlVAlignCenter;
            excellWorksheet.get_Range(rangeA, rangeB).MergeCells = merged;
            excellWorksheet.get_Range(rangeA, rangeB).Borders.Weight = Excel.XlBorderWeight.xlThin;   
    

        }

        public void setLargeHeading(String rangeA, String rangeB, Excel.Worksheet excellWorksheet)
        {
            excellWorksheet.get_Range(rangeA, rangeB).Font.Size = 14;
            excellWorksheet.get_Range(rangeA, rangeB).Font.Bold = true;
            excellWorksheet.get_Range(rangeA, rangeB).HorizontalAlignment = Excel.XlHAlign.xlHAlignCenter;
            excellWorksheet.get_Range(rangeA, rangeB).VerticalAlignment = Excel.XlVAlign.xlVAlignCenter;
            excellWorksheet.get_Range(rangeA, rangeB).MergeCells = "true";
            excellWorksheet.get_Range(rangeA, rangeB).Borders.Weight = Excel.XlBorderWeight.xlThin;   

        }

        public void setTableCell(String rangeA, String rangeB, Excel.Worksheet excellWorksheet)
        {
            excellWorksheet.get_Range(rangeA, rangeB).Borders.Weight = Excel.XlBorderWeight.xlThin;   
        }




    }
}
