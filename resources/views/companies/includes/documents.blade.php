 <div class="tab-pane" id="documents" role="tabpanel" aria-expanded="true">
                           
    <div class="row mb-2">
        <div class="col-6">
            <h4 class="mt-0 text-left">{{ @$company->name }} - Documents List </h4>
        </div>
        <div class="col-6 text-right">
            <button type="button" class="btn btn-danger mt-0"  onclick="return window.location.href='{{ route("companies.documents",['id' => request()->company ])  }}'">Add Document
            </button>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-12 text-right">
            <label>Per Page </label>
            <select style="height: 26px;" name="per_page"  onchange="selectPerpage(this.value)"> 
              <option value="">Per Page</option>
              <option value="25" {{ (request()->per_page == 25) ? 'selected' : ''}}>25</option>
              <option value="50" {{ (request()->per_page == 50) ? 'selected' : ''}}>50</option>
              <option value="100" {{ (request()->per_page == 100) ? 'selected' : ''}}> 100</option>
              <option value="150" {{ (request()->per_page == 150) ? 'selected' : ''}}>150</option>
              </select>
        </div>
    </div>

     <div class="row mb-2">
        <div class="col-12">
            <form>
            <select style="height: 26px;" name="document_type" > 
            <option value="">Select Documents Type</option>
            @foreach($documentTypes as $type)
               <option value="{{ $type->slug }}" {{ (@request()->document_type == $type->slug) ? 'selected' : ''}}> {{ $type->name }}</option>
            @endforeach
            </select>
            <select style="height: 26px;" name="employee"> 
              <option value="">Select Employee</option>
              @foreach($employees as $employee)
                 <option value="{{ $employee->id }}" {{ (@request()->employee == $employee->id) ? 'selected' : ''}}> {{ $employee->name }}</option>
              @endforeach
            </select> 

            <input type="text" name="s" value="{{ @request()->s }}" id="inputSearch" >
            <input type="hidden"  name="per_page" value="{{ @request()->per_page }}">
            <button id="search">Search</button>
          </form>
        </div>
    </div>
    <!-- Categories Table -->
    <div class="table-responsive">

      <table id="subcontractors-table" class="table card-table dataTable no-footer" role="grid" aria-describedby="subcontractors-table_info">
             <thead class="d-none">
                <tr role="row">
                   <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"></th>
                </tr>
             </thead>
             <tbody class="row">
               @foreach($documents as $document)

                   @php
                     $fileInfo = pathinfo($document->file); 
                       $extension = @$fileInfo['extension'];
                    
                        if(in_array($extension,['doc','docx','docm','dot',
                      'dotm','dotx'])){
                          $extension = 'word'; 
                       }
                       else if(in_array($extension,['csv','dbf','dif','xla',
                      'xls','xlsb','xlsm','xlsx','xlt','xltm','xltx'])){
                          $extension = 'excel'; 
                       }
                     
                      if(!$extension){
                        $extension = 'pdf';
                      }

                   @endphp

                <tr class="text-center col-lg-2 col-sm-3 odd" style="display: flex; flex-wrap: wrap;" role="row">
                   <td>
                        <span class="cross">
                          <form 
                            method="post" 
                            action="{{route('documents.destroy',$document->id).'#documents'}}"> 
                             @csrf
                            {{ method_field('DELETE') }}

                            <button 
                              type="submit"
                              onclick="return confirm('Are you sure?')"
                              class="btn btn-neutral bg-transparent btn-icon" data-original-title="Delete Property Type" title="Delete Property Type"><i class="fa fa-trash text-danger"></i> </button>
                          </form> 
                        </span>
                         <div class="card card-table-item" style="width: 100%; height: 100%;">
                            <div class="card-body pb-0">
                               <div class="author mt-1">
                                  <span class="doc_type_m">
                                    {{ @$document->property->property_name }} 
                                  </span></br>
                                 <a  href="{{ ($document->file) ? $document->file : route('companies.documents.show', ['id' => request()->company, 'document' => $document->id ]) }}" {{ ($document->file) ? 'target="_blank"' : '' }} >
                                  <img class="avatar border-gray" src="{{ asset('img/'.$extension.'.png') }}">  
                                   </a>
                                  <a href="{{ request()->company }}/documents/{{ $document->id }}">                     
                                  <h6 class="title mb-0">{{ @$document->name }}</h6>
                                   </a>
                                   <span class="doc-type"> 
                                    {{  @$document->document_type->name }}</span>
                                    <span class="doc_type_m"> 
                                    {{  @$document->vendor->name }}</span>
                                    <span class="doc_type_m"> 
                                    {{  @$document->subcontractor->name }}</span>
                                    <span class="doc_type_m">
                                      {{ (!$document->file) && $document->files()->exists() ? 'Multiple' : '' }}
                                    </span>
                                    
                               </div>
                            </div>
                         </div>
                     
                   </td>
                </tr>
               
               @endforeach
            
             </tbody>
          </table>
    </div>
    {!! $documents->render() !!}
</div>